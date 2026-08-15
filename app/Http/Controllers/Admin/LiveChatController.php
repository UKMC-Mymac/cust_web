<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatMessageSent;
use App\Events\ChatThreadStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use App\Services\ChatWebhookService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LiveChatController extends Controller
{
    protected $title;
    protected $route;
    protected $view;

    public function __construct()
    {
        $this->title = 'Live Chat Inbox';
        $this->route = 'admin.live-chat';
        $this->view = 'admin.live-chat';
        $this->middleware('permission:chat-manage');
    }

    public function index()
    {
        if (Auth::guard('web')->check()) {
            foreach (Auth::guard('web')->user()->unreadNotifications as $notification) {
                if (isset($notification->data['type']) && $notification->data['type'] == 'chat') {
                    $notification->markAsRead();
                }
            }
        }

        return view($this->view . '.index', [
            'title' => $this->title,
            'route' => $this->route,
            'pusherKey' => config('broadcasting.connections.pusher.key'),
            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster'),
        ]);
    }

    public function threads(Request $request)
    {
        $query = ChatThread::query()->with('assignedAdmin:id,first_name,last_name');

        if ($request->filled('status') && in_array((int) $request->status, [1, 2], true)) {
            $query->where('status', (int) $request->status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($builder) use ($search) {
                $builder->where('chat_id', 'like', '%' . $search . '%')
                    ->orWhere('visitor_name', 'like', '%' . $search . '%')
                    ->orWhere('visitor_email', 'like', '%' . $search . '%')
                    ->orWhere('visitor_phone', 'like', '%' . $search . '%');
            });
        }

        $threads = $query->orderByRaw('COALESCE(last_message_at, created_at) DESC')
            ->limit(100)
            ->get()
            ->map(function (ChatThread $thread) {
                $lastMessage = $thread->messages()->latest('id')->first();

                return [
                    'chat_id' => $thread->chat_id,
                    'status' => (int) $thread->status,
                    'visitor_name' => $thread->visitor_name,
                    'last_message_at' => optional($thread->last_message_at)->toDateTimeString(),
                    'last_message' => optional($lastMessage)->message,
                    'assigned_to' => trim(($thread->assignedAdmin->first_name ?? '') . ' ' . ($thread->assignedAdmin->last_name ?? '')),
                ];
            });

        return response()->json($threads);
    }

    public function messages($chatId)
    {
        $thread = ChatThread::where('chat_id', $chatId)
            ->with('assignedAdmin:id,first_name,last_name')
            ->firstOrFail();

        if (Auth::guard('web')->check()) {
            foreach (Auth::guard('web')->user()->unreadNotifications as $notification) {
                if (isset($notification->data['type']) && $notification->data['type'] == 'chat' && isset($notification->data['id']) && $notification->data['id'] == $thread->id) {
                    $notification->markAsRead();
                }
            }
        }

        $messages = $thread->messages()
            ->with('sender:id,first_name,last_name')
            ->orderBy('id', 'asc')
            ->get()
            ->map(function (ChatMessage $message) {
                return [
                    'id' => $message->id,
                    'sender_type' => (int) $message->sender_type,
                    'sender_name' => trim(($message->sender->first_name ?? '') . ' ' . ($message->sender->last_name ?? '')),
                    'message' => $message->message,
                    'created_at' => optional($message->created_at)->toDateTimeString(),
                ];
            });

        return response()->json([
            'chat_id' => $thread->chat_id,
            'status' => (int) $thread->status,
            'assigned_to' => trim(($thread->assignedAdmin->first_name ?? '') . ' ' . ($thread->assignedAdmin->last_name ?? '')),
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request, $chatId, ChatWebhookService $webhookService)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $thread = ChatThread::where('chat_id', $chatId)->firstOrFail();

        if ((int) $thread->status === 2) {
            return response()->json([
                'message' => 'This chat is closed. Reopen it before sending a reply.',
                'status' => 2,
            ], 422);
        }

        $message = ChatMessage::create([
            'thread_id' => $thread->id,
            'sender_type' => 2,
            'sender_user_id' => Auth::id(),
            'message' => trim($request->message),
        ]);

        $thread->assigned_admin_id = Auth::id();
        $thread->last_message_at = now();
        $thread->save();

        broadcast(new ChatMessageSent($thread, $message))->toOthers();
        $webhookService->dispatchMessageEvent($thread, $message);

        return response()->json([
            'id' => $message->id,
            'sender_type' => 2,
            'sender_name' => trim(Auth::user()->first_name . ' ' . Auth::user()->last_name),
            'message' => $message->message,
            'created_at' => optional($message->created_at)->toDateTimeString(),
        ]);
    }

    public function updateStatus(Request $request, $chatId, ChatWebhookService $webhookService)
    {
        $request->validate([
            'status' => 'required|in:1,2',
        ]);

        $thread = ChatThread::where('chat_id', $chatId)->firstOrFail();
        $thread->status = (int) $request->status;
        $thread->assigned_admin_id = Auth::id();
        $thread->save();

        broadcast(new ChatThreadStatusUpdated($thread, 'admin', Auth::id()))->toOthers();
        $webhookService->dispatchStatusEvent($thread, 'admin', Auth::id());

        Flasher::addSuccess('Chat status updated.', __('msg_success'));

        return response()->json([
            'chat_id' => $thread->chat_id,
            'status' => (int) $thread->status,
        ]);
    }

    public function destroy($chatId)
    {
        if (Auth::user()->is_admin == 1 || Auth::user()->hasRole('super-admin')) {
            $thread = ChatThread::where('chat_id', $chatId)->firstOrFail();
            
            DB::beginTransaction();
            try {
                $thread->messages()->delete();
                $thread->delete();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Failed to delete chat: ' . $e->getMessage()
                ], 500);
            }

            return response()->json([
                'message' => 'Chat deleted successfully.'
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized. Only Super Admin has access to delete chats.'
        ], 403);
    }

    public function destroyAll()
    {
        if (Auth::user()->is_admin == 1 || Auth::user()->hasRole('super-admin')) {
            DB::beginTransaction();
            try {
                \App\Models\ChatMessage::query()->delete();
                \App\Models\ChatThread::query()->delete();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Failed to delete all chats: ' . $e->getMessage()
                ], 500);
            }

            return response()->json([
                'message' => 'All chats deleted successfully.'
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized. Only Super Admin has access to delete all chats.'
        ], 403);
    }
}