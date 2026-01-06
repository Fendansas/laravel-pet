<?php

namespace App\Services\Task;

final readonly class TaskStatusResolver{

    public function byAssigned(?int $assignedToId): string
    {
        return $assignedToId ? 'assigned' : 'not_assigned';
    }
}
