<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Просмотр списка пользователей.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }

    /**
     * Просмотр конкретного пользователя.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }
}
