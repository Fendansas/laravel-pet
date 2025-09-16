<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'status_message' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $data['user_id'] = $user->id;

        UserProfile::create($data);

        return redirect()->route('user-profile.edit')->with('success', 'Профиль создан');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return $this->store($request);
        }

        $data = $request->validate([
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'status_message' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $profile->update($data);

        return redirect()->route('user-profile.edit')->with('success', 'Профиль обновлен');
    }
}
