<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class UserController extends Controller
{
    use AuthorizesRequests;
    public function index(){
        $users = User::with('profile')->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user){

        $user->load('profile'); // подгрузим профиль через Eloquent

        $this->authorize('view-user', $user); // проверка прав

        return view('admin.users.show', compact('user'));

    }

//    public function edit(User $user)
//    {
//        $this->authorize('update-user', $user);
//
//        return view('admin.users.edit', compact('user'));
//    }
//
//    public function destroy(User $user)
//    {
//        $this->authorize('delete-user', $user);
//
//        $user->delete();
//
//        return redirect()->route('admin.users.index')->with('success', 'Пользователь удалён');
//    }
}
