<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\UserFollowed;
use Illuminate\Support\Facades\DB;

class FollowService{

    public function follow(User $follower, User $user): bool{

        if ($follower->id === $user->id){
            throw new \DomainException('You cannot follow yourself.');
        }

        if ($follower->isFollowing($user)){
            return false;
        }

        DB::transaction(function () use ($follower, $user){
            $follower->followings()->attach($user->id);
            $user->notify(new UserFollowed($follower));
        });

        return true;
    }

    public function unfollow(User $follower, User $user): void{
        $follower->followings()->detach($user->id);
    }



}
