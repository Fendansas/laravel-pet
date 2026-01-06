<?php

namespace App\Services;

use App\Models\EventParticipant;
use Illuminate\Http\Request;

class EventParticipantService
{
    public function getParticipants(int $perPage = 10)
    {
        return EventParticipant::latest()->paginate($perPage);
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
