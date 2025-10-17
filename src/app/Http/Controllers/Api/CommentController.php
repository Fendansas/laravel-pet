<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // create new comment
    //  {
    //      "content": "Классная статья!",
    //      "parent_id": null
    //  }
    // reply to comment
    //  {
    //      "content": "Классная статья!",
    //      "parent_id": 9  // comment id
    //  }
    public function store(Request $request, Post $post){

        $data = $request->validate([
            'content' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = $post->comments()->create([
            'content' => $data['content'],
            'user_id' => auth()->id(),
            'parent_id' => $data['parent_id'] ?? null
        ]);

        return response()->json([
            'message' => 'Comment created.',
            'comment' => $comment->load('user'),
        ], 201);
    }

    public function destroy(Comment $comment)
    {
        if (auth()->id() !== $comment->user_id && !auth()->hasRole('admin')) {
            return response()->json([
                'error' => 'Not allowed to delete this comment.',
            ],403);
        }
        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted.',
        ], 200);
    }

    public function index(Post $post){
        $comments = $post->comments()
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return response()->json($comments);
    }







}
