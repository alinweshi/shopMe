<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Permission;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\permissions\StorePermissionRequest;
use App\Http\Requests\permissions\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function index()
    {
        return response()->json(Permission::all(), 200);
    }

    public function store(StorePermissionRequest $request)
    {
        // Get the validated data
        $validated = $request->validated();

        // Extract the role_id

        // Loop through the permission names and create them
        $createdPermissions = [];
        foreach ($validated['name'] as $permissionName) {
            $permission = Permission::create(['name' => $permissionName]);
            $createdPermissions[] = $permission;
        }

        // Return a response with the created permissions
        return response()->json([
            'message' => 'Permissions created successfully',
            'permissions' => $createdPermissions,
        ], 201);
    }

    public function show(Permission $permission)
    {
        return response()->json($permission, 200);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());

        return response()->json(['message' => 'Permission updated successfully', 'permission' => $permission], 200);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully'], 200);
    }
}
