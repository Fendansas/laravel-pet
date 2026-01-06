<?php

namespace App\Services;

use App\Models\UserProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarManager
{
    public function store(UploadedFile $file): string
    {
        return $file->store('avatars', 'public');
    }

    public function replace(UserProfile $profile, UploadedFile $file): string
    {
        if ($profile->avatar) {
            Storage::disk('public')->delete($profile->avatar);
        }

        return $this->store($file);
    }
}
