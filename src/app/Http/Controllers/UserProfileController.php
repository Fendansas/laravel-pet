<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use App\Models\User;
use App\Services\UserProfileService;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{

    public function __construct(
        protected UserProfileService $service
    ) {}


    public function edit()
    {
        $user = Auth::user();

        $profile = $this->service->getOrInit($user);

        return view('user-profile.edit', compact('profile'));
    }

    public function store(UserProfileRequest $request)
    {
        $profile = $this->service->createProfile(
            Auth::user(),
            $request->validated(),
            $request->file('avatar')
        );

        return redirect()->route('user-profile.edit')->with('success', 'Профиль создан');
    }

    public function update(UserProfileRequest $request)
    {
        $profile = $this->service->save(
            Auth::user(),
            $request->validated(),
            $request->file('avatar')
        );

        return redirect()->route('user-profile.edit')->with('success', 'Профиль обновлен');
    }

    public function index(Request $request){

        $users = $this->service->searchUsers($request->only([
            'name',
            'country',
            'city',
        ]));

        return view('user-profile.index', compact('users'));

    }

    public function show(User $user){
        $user->load('profile');

        $counters = $this->service->getCounters($user);

        return view('user-profile.show', [
            'user' => $user,
            'postsCount' => $counters['posts'],
            'commentsCount' => $counters['comments'],
        ]);
    }
}
