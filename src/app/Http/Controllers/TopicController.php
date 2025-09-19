<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::latest()->paginate(10);
        return view('topics.index', compact('topics'));
    }

    public function create()
    {
        return view('topics.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:topics,name',
        ]);

        $data['slug'] = Str::slug($data['name']);

        Topic::create($data);

        return redirect()->route('topics.index')->with('success', 'Тема создана!');
    }

    public function edit(Topic $topic){
        return view('topics.edit', compact('topic'));
    }
    public function update(Request $request, Topic $topic){
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:topics,name' . $topic->id,
        ]);

        $data['slug'] = Str::slug($data['name']);

        $topic->update($data);
        return redirect()->route('topics.index')->with('success', 'Тема обновлена');
    }

    public function destroy(Topic $topic){
        $topic->delete();

        return redirect()->route('topics.index')->with('success', 'Тема удалена');
    }
}
