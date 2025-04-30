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
            'super-admin' => ['edit orders', 'cancel orders'],
            'customer-support' => ['view complaints', 'resolve complaints'],
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            array_map(function ($permission) use ($roleName) {
                // dd(Role::where('name', $roleName)->first());
                Permission::create([
                    'name' => $permission,
                    'description' => ucfirst($permission),
                    'role_id' => Role::where('name', $roleName)->first()->id ?? null, // Assign role_id if found
                ]);
            }, $permissions); // Add the $permissions array as the second argument
        }

        // dd($roleName);
        // $role = Role::where('name', $roleName)->first();
        // dd($role->name);
        // dd($role->id);

        // foreach ($permissions as $permission) {
        //     Permission::create([
        //         'name' => $permission,
        //         'description' => ucfirst($permission),
        //         'role_id' => $role->id ?? null, // Assign role_id if found
        //     ]);
        // }
        // }
    }
}
