<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'create-review']);
        Permission::create(['name' => 'edit-review']);
        Permission::create(['name' => 'delete-review']);

        Permission::create(['name' => 'view-bookings']);
        Permission::create(['name' => 'edit-bookings']);
        Permission::create(['name' => 'delete-bookings']);

        Permission::create(['name' => 'create-comment']);
        Permission::create(['name' => 'update-comment']);
        Permission::create(['name' => 'delete-comment']);


        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $guestRole = Role::create(['name' => 'guest']);

        $adminRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',

            'create-review',
            'edit-review',
            'delete-review',

            'view-bookings',
            'edit-bookings',
            'delete-bookings',

            'create-comment',
            'update-comment',
            'delete-comment',

        ]);

        $userRole->givePermissionTo([
            'create-review',
            'edit-review',
            'delete-review',

            'view-bookings',
            'edit-bookings',
            'delete-bookings',

            'create-comment',
        ]);
    }
}
