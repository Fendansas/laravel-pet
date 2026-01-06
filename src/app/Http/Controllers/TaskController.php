<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Department;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Task;
use App\Services\Event\EventResolver;
use App\Services\Task\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService,
        private EventResolver $eventResolver,
    ) {}


    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $tasks = $this->taskService->paginateTasksForEvent($event->id);
        return view('tasks.index', compact('tasks', 'event'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
         $event = $this->eventResolver->findOrFail((int) $request->get('event_id'));
         $departments = Department::orderBy('name')->get();
         $participants = EventParticipant::orderBy('name')->get();

         return view('tasks.create', compact('event', 'departments', 'participants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->storeTask($request->validated());
        return redirect()
            ->route('events.show', $task->event_id)
            ->with('success', 'Task created successfully.');
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
        return view('tasks.edit', [
            'task'         => $task,
            'departments'  => Department::orderBy('name')->get(),
            'participants' => EventParticipant::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->taskService->updateTask($task, $request->validated());

        return redirect()
            ->route('events.show', $task->event_id)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $eventId = $task->event_id;
        $this->taskService->deleteTask($task);
        return redirect()
            ->route('events.show', $eventId)
            ->with('success', 'Task deleted successfully.');
    }
}
