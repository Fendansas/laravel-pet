<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Services\Event\EventResolver;
use Illuminate\Pagination\LengthAwarePaginator;

final class TaskService {

    public function __construct(
        private TaskStatusResolver $statusResolver,
        private EventResolver $eventResolver)
    {}

    public function paginateTasksForEvent (int $eventId, int $perPage = 10): LengthAwarePaginator{

        return Task::where('event_id', $eventId)
            ->with(['department', 'assignedTo'])
            ->paginate($perPage);
    }

    public function storeTask(array $validated): Task
    {
        $validated['status'] = $this->statusResolver
            ->byAssigned($validated['assigned_to'] ?? null);

        return Task::create($validated);
    }

    public function updateTask(Task $task, array $validated): Task{

        $task->update($validated);
        return $task->fresh(['event', 'department', 'assignedTo']);
    }

    public function deleteTask(Task $task): void{
        $task->delete();
    }

}
