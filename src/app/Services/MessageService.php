<?php

namespace App\Services;

use App\Models\Conversation;
use App\Events\MessageSent;

class MessageService
{
    public function getMessages(Conversation $conversation)
    {
        return $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();
    }

    public function sendMessage(
        Conversation $conversation,
        int $senderId,
        string $messageText
    ) {
        $message = $conversation->messages()->create([
            'sender_id' => $senderId,
            'message' => $messageText,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }
}
