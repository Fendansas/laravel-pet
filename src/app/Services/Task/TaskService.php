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

        $oldStatus = $task->status;

        $task->update($validated);

        if(
            $oldStatus != 'completed' &&
            $task->status === 'completed' &&
            !$task->is_paid
        ){
            $this->payForTask($task);
        }


        return $task->fresh(['event', 'department', 'assignedTo']);
    }

    public function deleteTask(Task $task): void{
        $task->delete();
    }

    public function bulkAction(array $data): void
    {
        $tasks = Task::whereIn('id', $data['task_ids'])->get();
        match ($data['action']) {
            'status'      => $this->bulkUpdateStatus($tasks, $data['status']),
            'assign'      => $this->bulkAssign($tasks, $data['assigned_to']),
            'department'  => $this->bulkSetDepartment($tasks, $data['department_id']),
            'delete'      => $this->bulkDelete($tasks),
            default       => throw new \InvalidArgumentException('Unknown action'),

        };
    }
    private function bulkUpdateStatus($tasks, string $status): void
    {
        foreach ($tasks as $task) {
            $oldStatus = $task->status;

            $task->update(['status' => $status]);

            if (
                $oldStatus !== 'completed'
                && $status === 'completed'
                && ! $task->is_paid
            ) {
                $this->payForTask($task);
            }
        }
    }

    private function bulkAssign($tasks, int $assignedTo): void
    {
        foreach ($tasks as $task) {
            $task->update([
                'assigned_to' => $assignedTo,
                'status'      => 'assigned',
            ]);
        }
    }
    private function bulkSetDepartment($tasks, int $departmentId): void{
        foreach ($tasks as $task) {
            $task->update(['department_id' => $departmentId]);
        }
    }

    private function bulkDelete($tasks): void
    {
        foreach ($tasks as $task) {
            $task->delete();
        }
    }

    private function payForTask(Task $task): void
    {
        if(! $task->assignedTo || $task->price <=0){
            return;
        }

        $task->assignedTo->increment('earned_money', $task->price);

        $task->update([
            'is_paid' => true,
            'completed_at' => now(),
            ]);
    }

}
