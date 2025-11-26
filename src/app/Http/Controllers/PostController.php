<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class PostController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){

        $topics = Topic::all();
        $query = Post::query()->with(['user', 'topic']);

        $this->authorize('viewAny', Post::class);

        if (!auth()->user()->hasPermission('view all posts')) {
            $query->published();
        }

        // сортировка по постам
        if($request->filled('topic_id')){
            $query->where('topic_id', $request->topic_id);
        }

        // писк по постам
        if ($request->filled('search')){
            $search = $request->search;

            $query->where(function($query) use ($search){
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest()->paginate(10)->withQueryString();
        return view('posts.index', compact('posts', 'topics'));
    }

    public function create(){
        $this->authorize('create', Post::class);
        $topics = Topic::all();
        return view('posts.create', compact('topics'));
    }
    public function store(Request $request){

        $this->authorize('create', Post::class);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'topic_id' => 'required|exists:topics,id',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date|after_or_equal:now',
        ]);

        $data['user_id'] = Auth::id();

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post){
        $this->authorize('view', $post);
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post){

        $this->authorize('update', $post);

        $topics = Topic::all();
        return view('posts.edit', compact('post', 'topics'));
    }

    public function update(Request $request, Post $post){

        $this->authorize('update', $post);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
//            'topic_id' => 'nullable|exists:topics,id',
//            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date|after_or_equal:now',
        ]);
        $post->update($data);

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post){

        $this->authorize('delete', $post);

        return redirect()->route('posts.index')->with('success', 'Пост успешно удалён.');
    }

    public function rate(Request $request, Post $post){
        $data = $request->validate([
            'rating' => 'nullable|integer:min:0|max:5',
        ]);

        PostRating::updateOrCreate(
            ['post_id' => $post->id, 'user_id' => Auth::id()],
            ['rating' => $data['rating']]
        );

        return back()->with('success', 'Вы оценили пост');
    }

    public function dashboard (Request $request){
        $topics = Topic::all();

        $query = Post::with('user', 'topic')->published();

        if($request->filled('topic_id')){
            $query->where('topic_id', $request->topic_id);
        }

        $posts = $query->latest()->paginate(10)->withQueryString();

        return view('dashboard', compact('posts', 'topics'));
    }


}
