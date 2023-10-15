<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['id' => Str::uuid()->toString(), 'name' => 'view products',  'guard_name' => 'web',]);
        Permission::create(['id' => Str::uuid()->toString(), 'name' => 'edit products',  'guard_name' => 'web',]);
        Permission::create(['id' => Str::uuid()->toString(), 'name' => 'view orders',  'guard_name' => 'web',]);
        Permission::create(['id' => Str::uuid()->toString(), 'name' => 'edit orders',  'guard_name' => 'web',]);
        Permission::create(['id' => Str::uuid()->toString(), 'name' => 'view users',  'guard_name' => 'web',]);
        Permission::create(['id' => Str::uuid()->toString(), 'name' => 'edit users',  'guard_name' => 'web',]);

        $adminRole = Role::create(['id' => Str::uuid()->toString(), 'name' => 'admin', 'guard_name' => 'web',]);
        $employeeRole = Role::create(['id' => Str::uuid()->toString(), 'name' => 'employee', 'guard_name' => 'web',]);
        $clientRole = Role::create(['id' => Str::uuid()->toString(), 'name' => 'client', 'guard_name' => 'web',]);

        $adminRole->givePermissionTo(Permission::all());
        $employeeRole->syncPermissions(['view products', 'edit products', 'view orders', 'edit orders', 'view users']);
        $clientRole->givePermissionTo('view products');

        $admin = User::find('beb46519-c62d-4675-9088-37be560768c5');
        $admin->assignRole('admin');

        $employee = User::find('2f505c2c-f8ee-4724-b5af-ed51219aaf88');
        $employee->assignRole('employee');

        $client = User::find('cf118e75-6556-41cd-940f-6f83f83c503c');
        $client->assignRole('client');
    }
}
