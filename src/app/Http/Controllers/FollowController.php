<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserFollowed;
use App\Services\FollowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FollowController extends Controller
{
    public function __construct(private FollowService $followService){}

    public function follow(User $user){
        try {
            $result = $this->followService->follow(Auth::user(), $user);

            if(!$result){
                return back()->with('info','You are already subscribed.');
            }
            return back()->with('success','You are subscribed.');
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function unfollow(User $user)
    {
        $follower = Auth::user();
        $follower->followings()->detach($user->id);

        return back()->with('success', 'Subscription canceled');
    }

    public function followers(User $user){
        $followers = $user->followers()->with('profile')->paginate(15);
        return view('user-profile.followers', compact('followers', 'user'));
    }

    public function following(User $user){
        $followings = $user->followings()->with('profile')->paginate(15);
        return view('user-profile.following', compact('followings','user'));
    }
}
