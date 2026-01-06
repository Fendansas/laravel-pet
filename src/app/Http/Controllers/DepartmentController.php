<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\DepartmentStoreRequest;
use App\Http\Requests\Department\DepartmentUpdateRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentService $service
    ) {}
    public function index(){

        $departments = $this->service->getDepartments();

        return view('departments.index', compact('departments'));
    }

    public function create(){
        return view('departments.create');
    }

    public function store(DepartmentStoreRequest $request){

        $this->service->createDepartment($request->validated());

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

        $this->service->updateDepartment($department, $request->validated());

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department){

        $this->service->deleteDepartment($department);

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
