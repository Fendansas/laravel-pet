<?php

namespace App\Services;

use App\Models\EventParticipant;
use Illuminate\Http\Request;

class EventParticipantService
{
    public function getParticipants(int $perPage = 10, ?string $sort = null, ?string $direction = 'desc')
    {
        $query = EventParticipant::withCount([
            'tasks',
            'tasks as completed_tasks_count' => function ($query) {
                $query->where('status', 'completed');
            }
        ]);
        if (in_array($sort,['tasks_count','completed_tasks_count'])) {
            $query->orderBy($sort, $direction === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }


        return $query->paginate($perPage)->withQueryString();
    }

    public function createParticipant(array $data): EventParticipant
    {
        return EventParticipant::create($data);
    }

    public function updateParticipant(EventParticipant $participant, array $data): bool
    {
        return $participant->update($data);
    }

    public function deleteParticipant(EventParticipant $participant): bool
    {
        return $participant->delete();
    }

    public function getParticipantTasks(EventParticipant $participant, ?string $status = null)
    {
        $query = $participant->tasks()->with(['event', 'department']);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function resolveStatusFromRequest(Request $request): ?string
    {
        return $request->get('status');
    }
}
