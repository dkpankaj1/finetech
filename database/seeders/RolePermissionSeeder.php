<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'super_admin',
            'admin',
            'manager',
            'teller',
            'viewer'
        ];

        collect($roles)->each(function ($role) {
            Role::create(['name' => $role]);
        })->toArray();

        $userPermissionGroup = PermissionGroup::create(['name' => 'User Management']);

        Permission::create(['name' => 'view_users', 'permission_group_id' => $userPermissionGroup->id]);
        Permission::create(['name' => 'create_users', 'permission_group_id' => $userPermissionGroup->id]);
        Permission::create(['name' => 'edit_users', 'permission_group_id' => $userPermissionGroup->id]);
        Permission::create(['name' => 'delete_users', 'permission_group_id' => $userPermissionGroup->id]);

        $rolePermissionGroup = PermissionGroup::create(['name' => 'Role Management']);
        Permission::create(['name' => 'view_roles', 'permission_group_id' => $rolePermissionGroup->id]);
        Permission::create(['name' => 'create_roles', 'permission_group_id' => $rolePermissionGroup->id]);
        Permission::create(['name' => 'edit_roles', 'permission_group_id' => $rolePermissionGroup->id]);
        Permission::create(['name' => 'delete_roles', 'permission_group_id' => $rolePermissionGroup->id]);

    }
}
