<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function store(Request $request, Post $post){
        $data = $request->validate([
            'content' => 'required|string|max:255',
        ]);
        $post->comments()->create([
            'content' => $data['content'],
            'user_id' => auth()->id(),
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
