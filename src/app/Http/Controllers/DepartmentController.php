<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\DepartmentStoreRequest;
use App\Http\Requests\Department\DepartmentUpdateRequest;
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

    public function store(DepartmentStoreRequest $request){

        Department::create($request->validated());

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(Department $department){
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(DepartmentUpdateRequest $request, Department $department){

        $department->update($request->validated());

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department){
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
