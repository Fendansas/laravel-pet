<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Services\TopicService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    public function __construct(
        protected TopicService $topicService
    ) {}
    public function index()
    {
        $topics = $this->topicService->listPaginated(10);
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

        $this->topicService->create($data);

        return redirect()->route('topics.index')->with('success', 'Тема создана!');
    }

    public function edit(Topic $topic){
        return view('topics.edit', compact('topic'));
    }
    public function update(Request $request, Topic $topic){

        $data = $request->validate([
            'name' => 'required|string|max:100|unique:topics,name' . $topic->id,
        ]);

       $this->topicService->update($topic, $data);

        return redirect()->route('topics.index')->with('success', 'Тема обновлена');
    }

    public function destroy(Topic $topic){

        $this->topicService->delete($topic);

        return redirect()->route('topics.index')->with('success', 'Тема удалена');
    }
}
