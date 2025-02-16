<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Before method: Super Admin has all permissions.
     */
    public function before(Admin $admin)
    {
        if ($admin->hasRole('super-admin')) {
            return true;
        }
    }

    /**
     * Check if an admin can manage products.
     */
    public function manageProducts(Admin $admin)
    {
        return $admin->hasRole('product-manager');
    }

    /**
     * Check if an admin can manage orders.
     */
    public function manageOrders(Admin $admin)
    {
        return $admin->hasRole('order-manager');
    }

    /**
     * Check if an admin can handle customer support.
     */
    public function handleSupport(Admin $admin)
    {
        return $admin->hasRole('customer-support');
    }

    /**
     * Check if an admin can manage financial tasks.
     */
    public function manageFinance(Admin $admin)
    {
        return $admin->hasRole('finance-admin');
    }

    /**
     * Check if an admin can manage content.
     */
    public function manageContent(Admin $admin)
    {
        return $admin->hasRole('content-manager');
    }

    /**
     * Check if an admin can manage vendors.
     */
    public function manageVendors(Admin $admin)
    {
        return $admin->hasRole('vendor-manager');
    }
}
