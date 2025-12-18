<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function store(CommentStoreRequest $request, Post $post){
        $data = $request->validated();
        $post->comments()->create([
            'content' => $data['content'],
            'user_id' => auth()->id(),
            'parent_id' => $data['parent_id'] ?? null,
            ]);

        return back()->with('success','Comment added');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'Not allowed');
        }

        $comment->delete();

        return back()->with('success','Comment deleted');
    }


}
