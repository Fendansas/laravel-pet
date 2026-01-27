<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Department;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Task;
use App\Services\Event\EventResolver;
use App\Services\Task\TaskChartService;
use App\Services\Task\TaskService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;


    public function __construct(
        private TaskService $taskService,
        private EventResolver $eventResolver,
        private TaskChartService $taskChartService,
    ) {}


    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $this->authorize('viewAny', Task::class);
        $tasks = $this->taskService->paginateTasksForEvent($event->id);
        $participants = EventParticipant::orderBy('name')->get();
        $departments  = Department::orderBy('name')->get();
        return view('tasks.index', compact(
            'tasks',
            'event',
            'participants',
            'departments')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
         $this->authorize('create', Task::class);
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
        $this->authorize('create', Task::class);
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
        $this->authorize('view', $task);
        $task->load(['event', 'department', 'assignedTo']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
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
        $this->authorize('update', $task);
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
        $this->authorize('delete', $task);
        $eventId = $task->event_id;
        $this->taskService->deleteTask($task);
        return redirect()
            ->route('events.show', $eventId)
            ->with('success', 'Task deleted successfully.');
    }

    public function bulk(Request $request){
        $this->authorize('updateAny', Task::class);

        $this->taskService->bulkAction($request->validated());

        return back()->with('success', 'Bulk action completed');

    }

    public function all()
    {
        $this->authorize('viewAny', Task::class);

        $tasks = Task::with(['event', 'department', 'assignedTo'])
            ->latest()
            ->paginate(20);

        $participants = EventParticipant::orderBy('name')->get();
        $departments  = Department::orderBy('name')->get();

        return view('tasks.all', compact(
            'tasks',
            'participants',
            'departments'
        ));
    }

    public function chart()
    {
        $this->authorize('viewAny', Task::class);

        $tasksByStatus = $this->taskChartService->byStatus();

        return view('tasks.chart', [
            'labels' => $tasksByStatus->pluck('status'),
            'data' => $tasksByStatus->pluck('total')
        ]);
    }


}
