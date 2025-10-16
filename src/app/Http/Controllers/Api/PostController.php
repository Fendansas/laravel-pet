<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostRating;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request){
        $query = Post::with([
            'user',
            'topic'
        ]);
        if ($request->filled('topic_id')){
            $query->where('topic_id', $request->topic_id);
        }

        if ($request->filled('search')){
            $search = $request->search;
            $query->where(function($q) use ($search){
               $q->where('title', 'like', '%'.$search.'%')
               ->orWhere('content', 'like', '%'.$search.'%');
            });
        }

        $posts = $query->latest()->paginate(10)->withQueryString();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    public function store(Request $request){

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'topic_id' => 'required|exists:topics,id'
        ]);

        $data['user_id'] = auth()->id();

        $post = Post::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Post created',
            'data' => $post
        ], 201);
    }

    public function show(Post $post){
        $post->load(['user', 'topic']);

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    public function update(Request $request, Post $post){

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'topic_id' => 'required|exists:topics,id'
        ]);

        $post->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Post updated',
            'data' => $post
        ]);
    }

    public function destroy(Post $post){

        if(Auth::id() != $post->user_id && !Auth::user()->hasRole('admin')){
            return response()->json([
                'success' => false,
                'message' => 'Not allowed to delete post'
            ]);
        }
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted'
        ]);
    }

    public function rate (Request $request, Post $post){
        $data = $request->validate([
            'rating' => 'required|integer|min:0|max:5'
        ]);

        $rating = PostRating::updateOrCreate(
            ['post_id' => $post->id, 'user_id' => auth()->id()],
            ['rating' => $data['rating']]
        );
        return response()->json([
            'success' => true,
            'message' => 'Rating updated',
            'data' => $rating
        ]);
    }

    public function topics()
    {
        return response()->json([
            'success' => true,
            'data' => Topic::all()
        ]);
    }


}
