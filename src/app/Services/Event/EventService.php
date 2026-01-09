<?php

namespace App\Services\Event;

use App\Models\Event;
use Illuminate\Http\Request;

class EventService
{
    public function getEvents(int $perPage = 15)
    {
        return Event::with('tasks')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function prepareEventData(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['status'] = 'active';

        return $data;
    }

    public function createEvent(array $data): Event
    {
        return Event::create(
            $this->prepareEventData($data)
        );
    }

    public function updateEvent(Event $event, array $data): bool
    {
        return $event->update($data);
    }

    public function resolveStatus(Request $request): ?string
    {
        return $request->get('status');
    }

    public function loadEventWithTasks(Event $event, ?string $status = null): Event
    {
        $event->load([
            'tasks' => function ($query) use ($status) {
                if ($status) {
                    $query->where('status', $status);
                }

                $query->orderBy('status')
                    ->orderByDesc('created_at');
            },
            'tasks.department',
            'tasks.assignedTo'
        ]);

        return $event;
    }
}
