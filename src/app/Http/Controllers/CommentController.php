<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function store(CommentStoreRequest $request, Post $post, CommentService $commentService){

        $commentService->create(
            $post,
            $request->validated(),
            auth()->user()
        );

        return back()->with('success','Comment added');
    }

    public function destroy(Comment $comment, CommentService $commentService)
    {
        $this->authorize('delete', $comment);

        $commentService->delete($comment);


        return back()->with('success','Comment deleted');
    }


}
