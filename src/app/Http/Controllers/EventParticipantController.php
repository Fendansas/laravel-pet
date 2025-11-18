<?php

namespace App\Http\Controllers;

use App\Models\EventParticipant;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participants = EventParticipant::latest()->paginate(10);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
           'name' => 'required|string',
           'email' => 'nullable|email',
           'phone' => 'nullable|string',
           'position' => 'nullable|string',
           'notes' => 'nullable|string',
        ]);

        EventParticipant::create($validated);

        return redirect()->route('participants.index')->with('message', 'Event Participant Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, EventParticipant $participant)
    {
        $status = $request->get('status');

        $tasksQuery = $participant->tasks()->with(['event', 'department']);

        if($status){
            $tasksQuery->where('status', $status);
        }

        $tasks = $tasksQuery->get();

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
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'position' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventParticipant $participant)
    {
        $participant->delete();

        return redirect()->route('participants.index')->with('message', 'Event Participant Deleted Successfully');
    }
}
