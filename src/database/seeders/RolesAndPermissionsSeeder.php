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
        $admin = Role::create(['name'=>'admin', 'label'=>'Admin', 'description'=>'Super admin']);
        $manager = Role::create(['name'=>'manager', 'label'=>'Manager']);
        $editor = Role::create(['name'=>'editor', 'label'=>'Editor']);
        $user = Role::create(['name'=>'user', 'label'=>'User']);

        $permissions = [
            'create posts',
            'edit own posts',
            'edit posts',
            'delete posts',
            'publish posts',
            'view published posts',
            'view all posts',
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
        ];

        foreach ($permissions as $permName) {
            Permission::create([
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
        ]);

        $user->permissions()->sync([
            $perms['create posts'],
            $perms['edit own posts'],
            $perms['view published posts'],
        ]);
        // ===== EDITOR =====
        $editor->permissions()->sync([
            $perms['edit posts'],
            $perms['publish posts'],
            $perms['view all posts'],

            $perms['view tasks'],
            $perms['edit any tasks'],
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

        // назначаем роль admin
        $adminUser->roles()->syncWithoutDetaching([$admin->id]);

    }
}
