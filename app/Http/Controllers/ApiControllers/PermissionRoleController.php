<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\permissions\createPermissionRoleRequest;
use App\Models\Permission;
use App\Models\Role;

class PermissionRoleController extends Controller
{
    public function createPermissionRole(Role $role, Permission $permission)
    {

        if ($role->permissions->contains($permission->id)) {
            return response()->json([
                'message' => 'Permission is already assigned to the role',
            ], 400);
        }
        // Attach the permission to the role
        $role->permissions()->attach($permission->id);

        // Return a success response
        return response()->json([
            'message' => 'Permission has been assigned to the role',
            'role' => $role->name,
            'permission' => $permission->name,
        ], 201);
    }
}
