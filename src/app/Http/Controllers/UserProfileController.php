<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $profile = $user->profile ?? new UserProfile([
            'user_id' => $user->id,
            'date_of_birth' => null,
            'gender' => null,
            'city' => null,
            'country' => null,
            'status_message' => null,
            'avatar' => null,
        ]);

        return view('user-profile.edit', compact('profile'));
    }

    public function store(UserProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $data['user_id'] = $user->id;

        UserProfile::create($data);

        return redirect()->route('user-profile.edit')->with('success', 'Профиль создан');
    }

    public function update(UserProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return $this->store($request);
        }

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $profile->update($data);

        return redirect()->route('user-profile.edit')->with('success', 'Профиль обновлен');
    }

    public function index(Request $request){

        $query = User::with('profile')
            ->select('id', 'name');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('country')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('country', 'like', '%'.$request->country.'%');
            });
        }

        if ($request->filled('city')) {
            $query->whereHas('profile', function ($q) use ($request) {
                $q->where('city', 'like', '%'.$request->city.'%');
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return view('user-profile.index', compact('users'));

    }

    public function show(User $user){
        $user->load('profile');

        $postsCount = $user->posts()->count();

        $commentsCount = $user->comments()->count();

        return view('user-profile.show', compact('user', 'postsCount', 'commentsCount'));
    }
}
