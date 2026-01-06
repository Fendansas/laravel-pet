<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserProfileService
{
    public function __construct(
        protected AvatarManager $avatarManager
    ) {}

    public function getOrInit(User $user): UserProfile
    {
        return $user->profile ?? new UserProfile([
            'user_id' => $user->id,
            'date_of_birth' => null,
            'gender' => null,
            'city' => null,
            'country' => null,
            'status_message' => null,
            'avatar' => null,
        ]);
    }

    public function createProfile(User $user, array $data, ?UploadedFile $avatar = null): UserProfile
    {
        if ($avatar) {
            $data['avatar'] = $this->avatarManager->store($avatar);
        }

        $data['user_id'] = $user->id;

        return UserProfile::create($data);
    }

    public function updateProfile(User $user, UserProfile $profile, array $data, ?UploadedFile $avatar = null): UserProfile
    {
        if ($avatar) {
            $data['avatar'] = $this->avatarManager->replace($profile, $avatar);
        }

        $profile->update($data);

        return $profile;
    }

    public function save(User $user, array $data, ?UploadedFile $avatar = null): UserProfile
    {
        $profile = $user->profile;

        if (!$profile) {
            return $this->createProfile($user, $data, $avatar);
        }

        return $this->updateProfile($user, $profile, $data, $avatar);
    }

    public function searchUsers(array $filters): LengthAwarePaginator
    {
        $query = User::with('profile')
            ->select('id', 'name')
            ->latest();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        if (!empty($filters['country'])) {
            $query->whereHas('profile', function ($q) use ($filters) {
                $q->where('country', 'like', '%'.$filters['country'].'%');
            });
        }

        if (!empty($filters['city'])) {
            $query->whereHas('profile', function ($q) use ($filters) {
                $q->where('city', 'like', '%'.$filters['city'].'%');
            });
        }

        return $query->paginate(15)->withQueryString();
    }

    public function getCounters(User $user): array
    {
        return [
            'posts' => $user->posts()->count(),
            'comments' => $user->comments()->count(),
        ];
    }
}
