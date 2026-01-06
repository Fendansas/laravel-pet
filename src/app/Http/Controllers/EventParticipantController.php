<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventParticipant\EventParticipantStoreRequest;
use App\Http\Requests\EventParticipant\EventParticipantUpdateRequest;
use App\Models\EventParticipant;
use App\Services\EventParticipantService;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    public function __construct(
        protected EventParticipantService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participants = $this->service->getParticipants();
        return view('participants.index', compact('participants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('participants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventParticipantStoreRequest $request)
    {

        $this->service->createParticipant($request->validated());

        return redirect()->route('participants.index')->with('message', 'Event Participant Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, EventParticipant $participant)
    {
        $status = $this->service->resolveStatusFromRequest($request);

        $tasks = $this->service->getParticipantTasks($participant, $status);

        return view('participants.show', compact('participant', 'tasks', 'status') );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventParticipant $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventParticipantUpdateRequest $request, EventParticipant $participant)
    {
        $this->service->updateParticipant($participant, $request->validated());

        return redirect()->route('participants.index')->with('message', 'Event Participant Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventParticipant $participant)
    {
        $this->service->deleteParticipant($participant);

        return redirect()->route('participants.index')->with('message', 'Event Participant Deleted Successfully');
    }
}
