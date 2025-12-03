<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::orderBy('name')->get();

        return view('admin.permissions.index', compact('permissions'));
    }
    public function create(){
        return view('admin.permissions.create');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'label' => 'nullable|string|max:255',
        ]);

        Permission::create($data);
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }

    public function edit(Permission $permission){
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission){
        $data = $request->validate([
            'name'  => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'label' => 'nullable|string|max:255',
        ]);

        $permission->update($data);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    public function destroy(Permission $permission){

        if ($permission->roles()->count()) {
            return back()->with('error', 'You cannot delete a right — it is assigned to roles.');
        }

        $permission->delete();

        return back()->with('success', 'Right deleted');
    }
}
