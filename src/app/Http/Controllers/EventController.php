<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Models\Event;
use App\Services\Event\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function __construct(
        protected EventService $service
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->service->getEvents();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventStoreRequest $request)
    {
        $this->service->createEvent($request->validated());

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Request $request)
    {
        $status = $this->service->resolveStatus($request);

        $event = $this->service->loadEventWithTasks($event, $status);

        return view('events.show', compact('event', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, Event $event)
    {

       $this->service->updateEvent($event, $request->validated());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
