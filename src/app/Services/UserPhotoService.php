<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserPhoto;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserPhotoService
{
    public function getForAuthUser(){

        return auth()->user()->photos()->latest()->get();
    }

    public function getForUser(User $user)
    {
        return $user->photos()->latest()->get();
    }
    public function uploadPhotos(array $files): void
    {
        foreach ($files as $photo) {
            /** @var UploadedFile $photo */
            $path = $photo->store('user_photo', 'public');

            auth()->user()->photos()->create([
                'path' => $path,
            ]);
        }
    }
    public function deletePhoto(UserPhoto $userPhoto): void
    {
        Storage::disk('public')->delete($userPhoto->path);

        $userPhoto->delete();
    }


}
