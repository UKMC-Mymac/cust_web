<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatThread;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatWebhookService
{
    public function dispatchMessageEvent(ChatThread $thread, ChatMessage $message): void
    {
        $url = config('services.chat.webhook_url');

        if (blank($url)) {
            return;
        }

        try {
            Http::timeout(5)->post($url, [
                'event' => 'chat.message.sent',
                'chat_id' => $thread->chat_id,
                'sender_type' => (int) $message->sender_type,
                'sender_user_id' => $message->sender_user_id,
                'message' => $message->message,
                'sent_at' => optional($message->created_at)->toIso8601String(),
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Chat webhook dispatch failed', [
                'chat_id' => $thread->chat_id,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function dispatchStatusEvent(ChatThread $thread, string $updatedBy = 'system', ?int $updatedByUserId = null): void
    {
        $url = config('services.chat.webhook_url');

        if (blank($url)) {
            return;
        }

        try {
            Http::timeout(5)->post($url, [
                'event' => 'chat.status.updated',
                'chat_id' => $thread->chat_id,
                'status' => (int) $thread->status,
                'updated_by' => $updatedBy,
                'updated_by_user_id' => $updatedByUserId,
                'updated_at' => now()->toIso8601String(),
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Chat status webhook dispatch failed', [
                'chat_id' => $thread->chat_id,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
