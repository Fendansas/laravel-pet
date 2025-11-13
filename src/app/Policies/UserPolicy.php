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
        return $user->isAdmin();
    }

    /**
     * Просмотр конкретного пользователя.
     */
    public function view(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    public function update(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin();
    }
}
