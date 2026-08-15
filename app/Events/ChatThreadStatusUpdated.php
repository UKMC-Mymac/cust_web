<?php

namespace App\Events;

use App\Models\ChatThread;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatThreadStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChatThread $thread;
    public ?int $updatedByUserId;
    public string $updatedBy;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatThread $thread, string $updatedBy = 'system', ?int $updatedByUserId = null)
    {
        $this->thread = $thread;
        $this->updatedBy = $updatedBy;
        $this->updatedByUserId = $updatedByUserId;
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
        return 'chat.status.updated';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'chat_id' => $this->thread->chat_id,
            'status' => (int) $this->thread->status,
            'updated_by' => $this->updatedBy,
            'updated_by_user_id' => $this->updatedByUserId,
            'updated_at' => now()->toDateTimeString(),
        ];
    }
}
