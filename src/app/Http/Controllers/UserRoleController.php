<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function edit(User $user){
        return view('admin.users.roles', [
            'user' => $user->load('roles'),
            'roles' => Role::all()
        ]);
    }

    public function update(Request $request, User $user){
        $user->roles()->sync($request->roles ?? []);
        return back()->with('success', 'Role(s) updated!');
    }

}
