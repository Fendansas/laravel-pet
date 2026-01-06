<?php

namespace App\Services;

use App\Models\User;

class BalanceService
{
    public function getBalance(User $user)
    {
        return $user->balance;
    }
}
