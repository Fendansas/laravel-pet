<?php

namespace App\Services;

use App\Models\Conversation;

class ConversationService{

    public function getUserConversations(int $userId)
    {
        return Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['userOne', 'userTwo'])
            ->get();
    }

    public function getOrCreateConversation(int $userOneId, int $userTwoId): Conversation
    {
        return Conversation::between($userOneId, $userTwoId)->first()
            ?? Conversation::create([
                'user_one_id' => $userOneId,
                'user_two_id' => $userTwoId,
            ]);
    }
}
