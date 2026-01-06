<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostRating;

class PostRatingService
{
    public function rate(Post $post, int $userId, ?int $rating): void
    {
        PostRating::updateOrCreate(
            ['post_id' => $post->id, 'user_id' => $userId],
            ['rating' => $rating]
        );
    }
}
