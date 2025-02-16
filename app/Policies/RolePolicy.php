<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Admin;

class RolePolicy
{
    /**
     * Determine whether the admin can view any roles.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermission('view_roles');
    }

    /**
     * Determine whether the admin can view a specific role.
     */
    public function view(Admin $admin, Role $role): bool
    {
        return $admin->hasPermission('view_role');
    }

    /**
     * Determine whether the admin can create roles.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermission('create_roles') || $admin->role->name === 'admin';
    }

    /**
     * Determine whether the admin can update a role.
     */
    public function update(Admin $admin, Role $role): bool
    {
        // Prevent updating high-privilege roles
        if ($this->isHighPrivilegeRole($role)) {
            return false;
        }

        return $admin->hasPermission('edit_roles');
    }

    /**
     * Determine whether the admin can delete a role.
     */
    public function delete(Admin $admin, Role $role): bool
    {
        // Prevent deleting high-privilege roles
        if ($this->isHighPrivilegeRole($role)) {
            return false;
        }

        return $admin->hasPermission('delete_roles');
    }

    /**
     * Determine whether the admin can restore a deleted role.
     */
    public function restore(Admin $admin, Role $role): bool
    {
        return $admin->hasPermission('restore_roles');
    }

    /**
     * Determine whether the admin can permanently delete a role.
     */
    public function forceDelete(Admin $admin, Role $role): bool
    {
        return $admin->hasPermission('force_delete_roles');
    }

    /**
     * Check if the role is a high-privilege role.
     */
    protected function isHighPrivilegeRole(Role $role): bool
    {
        return in_array($role->name, ['super-admin', 'admin']);
    }
}
