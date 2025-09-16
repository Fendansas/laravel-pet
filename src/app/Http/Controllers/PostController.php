<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
class PostController extends Controller
{
    public function index(){
        $posts = Post::with('user', 'topic')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create(){
        $topics = Topic::all();
        return view('posts.create', compact('topics'));
    }
    public function store(Request $request){
        $data = $request->validate([
           'title' => 'required|string|max:255',
           'content' => 'required|string',
           'rating' => 'nullable|integer:|min:0|max:5',
        ]);

        $data['user_id'] = Auth::id();

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }


}
