<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        ];

        foreach ($permissions as $perm) {
            Permission::create([
                'name' => $perm,
                'label' => $labels[$perm]]);
        }
        // получаем все премишены и id
        $perms = Permission::pluck('id','name');

        $user->permissions()->sync([
            $perms['create posts'],
            $perms['edit own posts'],
            $perms['view published posts'],
        ]);

        $user->permissions()->sync([
            $perms['create posts'],
            $perms['edit own posts'],
            $perms['view published posts'],
        ]);

        $editor->permissions()->sync([
            $perms['edit posts'],
            $perms['publish posts'],
            $perms['view all posts'],
        ]);

        $manager->permissions()->sync([
            $perms['edit posts'],
            $perms['publish posts'],
            $perms['view all posts'],
            $perms['delete posts'],
        ]);


        $admin->permissions()->sync($perms->values()->toArray());


    }
}
