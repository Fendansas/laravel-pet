<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService
{

    public function getPostsForIndex(Request $request, $user): LengthAwarePaginator
    {

        $query = Post::with(['user', 'topic']);

        if (!$user->hasPermission('view all posts')) {
            $query->published();
        }

        $this->applyFilters($query, $request);
        return $query->latest()->paginate(10)->withQueryString();
    }

    public function getPostsForDashboard(Request $request): LengthAwarePaginator
    {
        $query = Post::with(['user', 'topic'])->published();

        if ($request->filled('topic_id')) {
            $query->where('topic_id', $request->topic_id);
        }

        return $query->latest()->paginate(10)->withQueryString();
    }

    public function create(array $data, int $userId): Post
    {
        $data['user_id'] = $userId;
        return Post::create($data);
    }

    public function update(Post $post, array $data): void
    {
        $post->update($data);
    }

    protected function applyFilters($query, Request $request): void
    {
        if ($request->filled('topic_id')) {
            $query->where('topic_id', $request->topic_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(fn($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
            );
        }
    }
}
