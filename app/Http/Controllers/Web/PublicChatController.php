<?php

namespace App\Http\Controllers\Web;

use App\Events\ChatMessageSent;
use App\Events\ChatThreadStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatThread;
use App\Services\ChatWebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Notifications\ChatNotification;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class PublicChatController extends Controller
{
    public function startSession(Request $request)
    {
        $request->validate([
            'chat_id' => 'nullable|string|max:32',
            'force_new' => 'nullable|boolean',
            'visitor_name' => 'nullable|string|max:100',
            'visitor_email' => 'nullable|email|max:100',
            'visitor_phone' => 'nullable|string|max:30',
        ]);

        $chatId = $request->chat_id;
        $forceNew = (bool) $request->boolean('force_new');

        if (!$forceNew && !empty($chatId)) {
            $thread = ChatThread::where('chat_id', $chatId)->first();
        }

        if (empty($thread)) {
            do {
                $chatId = 'CHAT' . strtoupper(Str::random(8));
            } while (ChatThread::where('chat_id', $chatId)->exists());

            $thread = ChatThread::create([
                'chat_id' => $chatId,
                'visitor_name' => $request->visitor_name,
                'visitor_email' => $request->visitor_email,
                'visitor_phone' => $request->visitor_phone,
                'status' => 1,
            ]);
        }

        return response()->json([
            'chat_id' => $thread->chat_id,
            'status' => (int) $thread->status,
        ]);
    }

    public function messages($chatId)
    {
        $thread = ChatThread::where('chat_id', $chatId)->firstOrFail();

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
                'message' => 'This chat is closed by the support team.',
            ], 422);
        }

        $message = ChatMessage::create([
            'thread_id' => $thread->id,
            'sender_type' => 1,
            'message' => trim($request->message),
        ]);

        $thread->last_message_at = now();
        $thread->save();

        // Send database notification to admin(s)
        try {
            // Remove previous unread chat notifications for this thread to avoid spam/accumulation
            DB::table('notifications')
                ->where('type', ChatNotification::class)
                ->where('data->id', $thread->id)
                ->delete();

            // Determine recipient(s)
            $recipients = null;
            if ($thread->assignedAdmin) {
                if ($thread->assignedAdmin->status == 1) {
                    $recipients = $thread->assignedAdmin;
                }
            } else {
                $recipients = User::where('status', '1')->get();
            }

            if ($recipients) {
                Notification::send($recipients, new ChatNotification([
                    'id' => $thread->id,
                    'title' => 'New chat message from ' . ($thread->visitor_name ?: 'Guest'),
                    'type' => 'chat',
                ]));
            }
        } catch (\Exception $e) {
            // Log notification failure to prevent breaking chat messaging flow
            logger()->error('Failed to send ChatNotification: ' . $e->getMessage());
        }

        broadcast(new ChatMessageSent($thread, $message))->toOthers();
        $webhookService->dispatchMessageEvent($thread, $message);

        return response()->json([
            'id' => $message->id,
            'sender_type' => 1,
            'message' => $message->message,
            'created_at' => optional($message->created_at)->toDateTimeString(),
        ]);
    }

    public function leaveChat($chatId, ChatWebhookService $webhookService)
    {
        $thread = ChatThread::where('chat_id', $chatId)->firstOrFail();

        if ((int) $thread->status !== 2) {
            $thread->status = 2;
            $thread->save();

            broadcast(new ChatThreadStatusUpdated($thread, 'visitor'))->toOthers();
            $webhookService->dispatchStatusEvent($thread, 'visitor');
        }

        return response()->json([
            'chat_id' => $thread->chat_id,
            'status' => (int) $thread->status,
            'message' => 'You have left this chat.',
        ]);
    }
}
