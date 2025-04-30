<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin'],
            ['name' => "super-admin"],
            ['name' => 'order-manager'],
            ['name' => 'customer-support'],
            ['name' => 'finance-admin'],
            ['name' => 'vendor-manager'],
            ['name' => 'content-manager'],
            ['name' => 'marketing-manager'],
            ['name' => 'sales-manager'],
            ['name' => 'shipping-manager'],
            ['name' => 'returns-manager'],
            ['name' => 'warehouse-manager'],
            ['name' => 'inventory-manager'],
            ['name' => 'customer-service'],
            ['name' => 'returns-supervisor'],
            ['name' => 'warehouse-supervisor'],
            ['name' => 'inventory-supervisor'],
            ['name' => 'content-supervisor'],
            ['name' => 'marketing-supervisor'],
            ['name' => 'sales-supervisor'],
            ['name' => 'shipping-supervisor'],
        ];
        // \App\Models\Role::truncate(); // Clear existing roles before seeding new ones
        foreach ($roles as $role) {
            \App\Models\Role::updateOrCreate(['name' => $role['name']], $role); // Update or create new role
        }
    }
}
