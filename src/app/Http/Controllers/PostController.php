<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostRating;
use App\Services\PostRatingService;
use App\Services\PostService;
use App\Services\TopicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class PostController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request, PostService $postService, TopicService $topicService){


        $this->authorize('viewAny', Post::class);

        $posts = $postService->getPostsForIndex($request, auth()->user());

        $topics = $topicService->all();

        return view('posts.index', compact('posts', 'topics'));

    }

    public function create(TopicService $topicService){
        $this->authorize('create', Post::class);
        $topics = $topicService->all();
        return view('posts.create', compact('topics'));
    }
    public function store(PostRequest $request, PostService $postService){

        $postService->create($request->validated(), Auth::id());

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post){
        $this->authorize('view', $post);
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post, TopicService $topicService){

        $this->authorize('update', $post);

        $topics = $topicService->all();
        return view('posts.edit', compact('post', 'topics'));
    }

    public function update(PostRequest $request, Post $post, PostService $postService){

        $postService->update($post, $request->validated());

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post){

        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Пост успешно удалён.');
    }

    public function rate(Request $request, Post $post, PostRatingService $ratingService){
        $data = $request->validate([
            'rating' => 'nullable|integer:min:0|max:5',
        ]);

        $ratingService->rate($post, Auth::id(), $data['rating']);

        return back()->with('success', 'Вы оценили пост');
    }

    public function dashboard (Request $request, PostService $postService, TopicService $topicService){

        $topics = $topicService->all();

        $query = Post::with('user', 'topic')->published();

        $posts = $postService->getPostsForDashboard($request);
        $topics = $topicService->all();

        return view('dashboard', compact('posts', 'topics'));
    }


}
