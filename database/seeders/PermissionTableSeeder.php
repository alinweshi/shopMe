<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        // Define roles and their permissions
        $rolePermissions = [
            'super-admin' => ['create products', 'edit products', 'delete products'],
            'order-manager' => ['edit orders', 'cancel orders'],
            'customer-support' => ['view complaints', 'resolve complaints'],
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();

            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'description' => ucfirst($permission),
                    'role_id' => $role->id ?? null, // Assign role_id if found
                ]);
            }
        }
    }
}
