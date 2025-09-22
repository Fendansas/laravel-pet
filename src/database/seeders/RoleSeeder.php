<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        $roles = ['admin', 'manager', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }


        $users = User::all();

        foreach ($users as $user) {
            if ($user->role) {
                $user->assignRole($user->role);
            } else {
                $user->assignRole('user');
            }
        }
    }
}
