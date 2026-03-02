<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name'=>'admin', 'label'=>'Admin', 'description'=>'Super admin']);
        $manager = Role::firstOrCreate(['name'=>'manager', 'label'=>'Manager']);
        $editor = Role::firstOrCreate(['name'=>'editor', 'label'=>'Editor']);
        $user = Role::firstOrCreate(['name'=>'user', 'label'=>'User']);

        $permissions = [
            'create posts',
            'edit own posts',
            'edit posts',
            'delete posts',
            'publish posts',
            'view published posts',
            'view all posts',
            // TASKS
            'create tasks',
            'view tasks',
            'edit own tasks',
            'edit any tasks',
            'delete own tasks',
            'delete any tasks',
            'restore tasks',
            'force delete tasks',
            // ITEMS
            'create items',
            'view items',
            'edit items',
            'delete items',
            'restore items',
            'force delete items',
            // EVENTS
            'create events',
            'view events',
            'edit events',
            'delete events',
        ];
        $labels = [
            'create posts'          => 'Create posts',
            'edit own posts'        => 'Edit own posts',
            'edit posts'            => 'Edit posts',
            'delete posts'          => 'Delete posts',
            'publish posts'         => 'Publish posts',
            'view published posts'  => 'View published posts',
            'view all posts'        => 'View all posts',
            // TASKS
            'create tasks'         => 'Create tasks',
            'view tasks'           => 'View tasks',
            'edit own tasks'       => 'Edit own tasks',
            'edit any tasks'       => 'Edit any tasks',
            'delete own tasks'     => 'Delete own tasks',
            'delete any tasks'     => 'Delete any tasks',
            'restore tasks'        => 'Restore tasks',
            'force delete tasks'   => 'Force delete tasks',
            // ITEMS
            'create items'       => 'Create items',
            'view items'         => 'View items',
            'edit items'         => 'Edit items',
            'delete items'       => 'Delete items',
            'restore items'      => 'Restore items',
            'force delete items' => 'Force delete items',
            // EVENTS
            'create events' => 'Create events',
            'view events'   => 'View events',
            'edit events'   => 'Edit events',
            'delete events' => 'Delete events',
        ];

        foreach ($permissions as $permName) {
            Permission::firstOrCreate([
                'name' => $permName,
                'label' => $labels[$permName]?? $permName]);
        }
        // получаем все премишены и id
        $perms = Permission::pluck('id','name');
        // ===== USER =====
        $user->permissions()->sync([
            $perms['create posts'],
            $perms['edit own posts'],
            $perms['view published posts'],

            $perms['create tasks'],
            $perms['view tasks'],
            $perms['edit own tasks'],
            $perms['delete own tasks'],

            $perms['create items'],
            $perms['view items'],

            $perms['view events'],
        ]);

        // ===== EDITOR =====
        $editor->permissions()->sync([
            $perms['edit posts'],
            $perms['publish posts'],
            $perms['view all posts'],

            $perms['view tasks'],
            $perms['edit any tasks'],

            $perms['view items'],
            $perms['edit items'],

            $perms['view events'],
            $perms['edit events'],
        ]);
        // ===== MANAGER =====
        $manager->permissions()->sync([
            $perms['edit posts'],
            $perms['publish posts'],
            $perms['view all posts'],
            $perms['delete posts'],

            $perms['create tasks'],
            $perms['view tasks'],
            $perms['edit any tasks'],
            $perms['delete any tasks'],

            $perms['create items'],
            $perms['view items'],
            $perms['edit items'],
            $perms['delete items'],

            $perms['create events'],
            $perms['view events'],
            $perms['edit events'],
        ]);

        // ===== ADMIN =====
        $admin->permissions()->sync($perms->values()->toArray());

        // ====== CREATE ADMIN ========
        $adminUser = User::firstOrCreate(
            ['email' => 'fendansas@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin'),
            ]
        );
        $adminUser->roles()->sync([$admin->id]);

    }
}
