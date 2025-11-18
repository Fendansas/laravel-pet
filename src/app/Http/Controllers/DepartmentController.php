<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(){
        $departments = Department::orderBy('id', 'desc')->paginate(10);
        return view('departments.index', compact('departments'));
    }

    public function create(){
        return view('departments.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(Department $department){
        return view('departments.show', compact('department'));
    }

    public function edit(Request $request, Department $department){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);
        $department->update($validated);
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department){
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
