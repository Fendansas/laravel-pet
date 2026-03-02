<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        return $user->isAdmin() ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view events');
    }

    public function view(User $user, Event $event): bool
    {
        return $user->hasPermission('view events');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('create events');
    }

    public function update(User $user, Event $event): bool
    {
        return $user->hasPermission('edit events');
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->hasPermission('delete events');
    }
}
