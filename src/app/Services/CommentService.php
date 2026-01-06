<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;


class CommentService
{
    public function create(Post $post, array $data, User $user): Comment
    {
        return $post->comments()->create([
            'content'   => $data['content'],
            'user_id'   => $user->id,
            'parent_id' => $data['parent_id'] ?? null,
        ]);
    }

    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
