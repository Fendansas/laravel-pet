<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $tasks = $event->tasks()->with(['department', 'assignedTo'])->paginate(10);
        return view('tasks.index', compact('tasks', 'event'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
         $event = Event::findOrFail($request->get('event_id'));
         $departments = Department::orderBy('name')->get();
         $participants = EventParticipant::orderBy('name')->get();

         return view('tasks.create', compact('event', 'departments', 'participants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'department_id' => 'required|exists:departments,id',
            'assigned_to' => 'required|exists:event_participants,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
        ]);

        Task::create($data);

        return redirect()->route('events.show', $data['event_id'])->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['event', 'department', 'assignedTo']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $departments = Department::orderBy('name')->get();
        $participants = EventParticipant::orderBy('name')->get();

        return view('tasks.edit', compact('task', 'departments', 'participants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'assigned_to' => 'nullable|exists:event_participants,id',
            'status' => 'required|string',
            'deadline' => 'nullable|date',
        ]);

        $task->update($data);

        return redirect()->route('events.show', $task->event_id)->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $eventId = $task->event_id;
        $task->delete();
        return redirect()->route('events.show', $eventId)->with('success', 'Task deleted successfully.');
    }
}
