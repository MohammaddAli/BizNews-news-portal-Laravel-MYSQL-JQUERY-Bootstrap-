<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Admin', 'guard_name' => 'employee']);
        $writer = Role::create(['name' => 'Writer', 'guard_name' => 'employee']);

        $permissions = [
            ['name' => 'role-list', 'guard_name' => 'employee'],
            ['name' => 'role-create', 'guard_name' => 'employee'],
            ['name' => 'role-edit', 'guard_name' => 'employee'],
            ['name' => 'role-delete', 'guard_name' => 'employee'],
            ['name' => 'write article', 'guard_name' => 'employee'],
            ['name' => 'read article', 'guard_name' => 'employee'],
            ['name' => 'update article', 'guard_name' => 'employee'],
            ['name' => 'delete article', 'guard_name' => 'employee'],
            ['name' => 'CRUD employee', 'guard_name' => 'employee'],
            ['name' => 'CRUD category', 'guard_name' => 'employee'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Permission::create(['name'=>'CRUD mails']);
        $admin->givePermissionTo(Permission::pluck('name')->all());
        $writer->givePermissionTo(['write article', 'read article', 'update article']);
    }
}
