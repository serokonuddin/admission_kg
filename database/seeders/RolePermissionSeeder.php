<?php

namespace Database\Seeders;


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
        // Define Permissions
        $permissions = [
            'view_users',
            'create_users',
            'edit_users',
            'update_users',
            'delete_users'
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Roles
        $roles = [
            'superadmin',
            'web_admin',
            'teacher',
            'student',
            'morning_shift',
            'day_shift',
            'gb_chairman',
            'principal',
            'vice_principal',
            'adjutant',
            'registration',
            'office',
            'finanace'
        ];

        // Roles With Permissions

        $rolesWithPermissions = [
            'superadmin' => $permissions,
            'web_admin' => $permissions,
            'teacher' => ['view_users', 'create_users', 'update_users', 'edit_users'],
            'student' => ['view_users'],
            'morning_shift' => ['view_users'],
            'day_shift' => ['view_users'],
            'gb_chairman' => ['view_users'],
            'principal' => ['view_users'],
            'vice_principal' => ['view_users'],
            'adjutant' => ['view_users'],
            'registration' => ['view_users', 'create_users', 'edit_users'],
            'office' => ['view_users', 'create_users'],
            'finanace' => ['view_users', 'create_users'],
        ];

        foreach ($rolesWithPermissions as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);
            $role->syncPermissions($rolePermissions); // Assign Permissions
        }
    }
}
