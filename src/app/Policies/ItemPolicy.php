<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItemPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        return $user->isAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view items');
    }

    public function view(User $user, Item $item): bool
    {
        return $user->hasPermission('view items');
    }

    public function create(User $user): bool
    {;
        return $user->hasPermission('create items');
    }

    public function update(User $user, Item $item): bool
    {
        return $user->hasPermission('edit items');
    }

    public function delete(User $user, Item $item): bool
    {
        return $user->hasPermission('delete items');
    }

    public function restore(User $user, Item $item): bool
    {
        return $user->hasPermission('restore items');
    }

    public function forceDelete(User $user, Item $item): bool
    {
        return $user->hasPermission('force delete items');
    }
}

