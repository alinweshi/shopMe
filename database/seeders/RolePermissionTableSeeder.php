<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleIds=Role::pluck('id');
        $permissionIds=Permission::pluck('id');
        

$rolePermissions = [
    'admin' => [
        'view_dashboard',
        'view_roles', 'create_roles', 'edit_roles', 'delete_roles',
        'view_users', 'create_users', 'edit_users', 'delete_users',
        'view_orders', 'create_orders', 'edit_orders', 'delete_orders',
        'view_customers', 'create_customers', 'edit_customers', 'delete_customers',
        'view_finances', 'create_finances', 'edit_finances', 'delete_finances',
        'view_vendors', 'create_vendors', 'edit_vendors', 'delete_vendors',
        'view_content', 'create_content', 'edit_content', 'delete_content',
        'view_marketing', 'create_marketing', 'edit_marketing', 'delete_marketing',
        'view_sales', 'create_sales', 'edit_sales', 'delete_sales',
        'view_shipping', 'create_shipping', 'edit_shipping', 'delete_shipping',
        'view_returns', 'create_returns', 'edit_returns', 'delete_returns',
        'view_warehouse', 'create_warehouse', 'edit_warehouse', 'delete_warehouse',
        'view_inventory', 'create_inventory', 'edit_inventory', 'delete_inventory',
    ],
    'super-admin' => [
        'view_dashboard',
        'view_roles', 'create_roles', 'edit_roles', 'delete_roles',
        'view_users', 'create_users', 'edit_users', 'delete_users',
        'view_orders', 'create_orders', 'edit_orders', 'delete_orders',
        'view_customers', 'create_customers', 'edit_customers', 'delete_customers',
        'view_finances', 'create_finances', 'edit_finances', 'delete_finances',
        'view_vendors', 'create_vendors', 'edit_vendors', 'delete_vendors',
        'view_content', 'create_content', 'edit_content', 'delete_content',
        'view_marketing', 'create_marketing', 'edit_marketing', 'delete_marketing',
        'view_sales', 'create_sales', 'edit_sales', 'delete_sales',
        'view_shipping', 'create_shipping', 'edit_shipping', 'delete_shipping',
        'view_returns', 'create_returns', 'edit_returns', 'delete_returns',
        'view_warehouse', 'create_warehouse', 'edit_warehouse', 'delete_warehouse',
        'view_inventory', 'create_inventory', 'edit_inventory', 'delete_inventory',
        ],
    'order-manager' => [
        'view_dashboard',
        'view_orders', 'create_orders', 'edit_orders', 'delete_orders',
    ],
    'customer-support' => [
        'view_dashboard',
        'view_customers', 'edit_customers',
    ],
    'finance-admin' => [
        'view_dashboard',
        'view_finances', 'create_finances', 'edit_finances', 'delete_finances',
    ],
    'vendor-manager' => [
        'view_dashboard',
        'view_vendors', 'create_vendors', 'edit_vendors', 'delete_vendors',
    ],
    'content-manager' => [
        'view_dashboard',
        'view_content', 'create_content', 'edit_content', 'delete_content',
    ],
    'marketing-manager' => [
        'view_dashboard',
        'view_marketing', 'create_marketing', 'edit_marketing', 'delete_marketing',
    ],
    'sales-manager' => [
        'view_dashboard',
        'view_sales', 'create_sales', 'edit_sales', 'delete_sales',
    ],
    'shipping-manager' => [
        'view_dashboard',
        'view_shipping', 'create_shipping', 'edit_shipping', 'delete_shipping',
    ],
    'returns-manager' => [
        'view_dashboard',
        'view_returns', 'create_returns', 'edit_returns', 'delete_returns',
    ],
    'warehouse-manager' => [
        'view_dashboard',
        'view_warehouse', 'create_warehouse', 'edit_warehouse', 'delete_warehouse',
    ],
    'inventory-manager' => [
        'view_dashboard',
        'view_inventory', 'create_inventory', 'edit_inventory', 'delete_inventory',
    ],
    // Add mappings for supervisor roles as needed
];
    }
}
