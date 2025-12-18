<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
     public function index(){
         return view('admin.roles.index', ['roles'=> Role::with('permissions')->get()]);
     }

     public function create(){
         return view('admin.roles.create');
     }

     public function store(RoleStoreRequest $request){

         Role::create($request->validated());

         return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
     }

     public function edit(Role $role){
         return view('admin.roles.edit',[
             'role' => $role->load('permissions'),
             'permissions' => Permission::all()
         ]);
     }

     public function update(RoleUpdateRequest $request, Role $role){
         $role->update($request->validated());
         $role->permissions()->sync($request->permissions ?? []);

         return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
     }

     public function destroy(Role $role){
         $role->delete();
         return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
     }
}
