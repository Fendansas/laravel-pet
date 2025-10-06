<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserFollowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FollowController extends Controller
{
    public function follow(User $user){
        $follower = Auth::user();

        if ($follower->id === $user->id){
            return back()->with('error', 'You cannot follow yourself.');
        }

        if (!$follower->isFollowing($user)){
            $follower->followings()->attach($user->id);

            $user->notify(new UserFollowed($follower));
        }

        return back()->with('success', 'You have subscribed to the user');

    }

    public function unfollow(User $user)
    {
        $follower = Auth::user();
        $follower->followings()->detach($user->id);

        return back()->with('success', 'Subscription canceled');
    }
}
