<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class UserController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request){

        $query = User::with('profile');

        if($request->filled('id')){
            $query->where('id', $request->id);
        }

        if($request->filled('name')){
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if($request->filled('email')){
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        if($request->filled('phone')){
            $query->where('phone', 'like', '%'.$request->phone.'%');
        }

        if($request->filled('country')){
            $query->whereHas('profile', function($q) use($request){
                $q->where('country', 'like', '%'.$request->country.'%');
            });
        }

        if($request->filled('city')){
            $query->whereHas('profile', function($q) use($request){
                $q->where('city', 'like', '%'.$request->city.'%');
            });
        }

        if ($request->filled('language')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('language', $request->language);
            });
        }

        $sort = $request->get('sort', 'id');

        $direction = $request->get('direction', 'desc');

        if(in_array($sort, ['country', 'city', 'languages'])){
            $query->join('user_profiles', 'user_id', '=','user_profiles.user_id')
                ->orderBy('user_profiles' . $sort, $direction)
                ->select('users.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $users = $query->paginate(15)->withQueryString();

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
