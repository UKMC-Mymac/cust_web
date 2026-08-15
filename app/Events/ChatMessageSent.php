<?php

namespace App\Events;

use App\Models\ChatMessage;
use App\Models\ChatThread;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChatThread $thread;
    public ChatMessage $message;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatThread $thread, ChatMessage $message)
    {
        $this->thread = $thread;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('public-chat.' . $this->thread->chat_id),
            new Channel('admin-chat.inbox'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'chat.message.sent';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'chat_id' => $this->thread->chat_id,
            'message_id' => $this->message->id,
            'sender_type' => (int) $this->message->sender_type,
            'sender_name' => $this->message->sender?->first_name . ' ' . $this->message->sender?->last_name,
            'message' => $this->message->message,
            'created_at' => optional($this->message->created_at)->toDateTimeString(),
            'status' => (int) $this->thread->status,
        ];
    }
}
