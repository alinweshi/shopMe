<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Role;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function __construct()
    {
        // Apply middleware or other setup if needed
    }

    public function index()
    {
        // Authorize the action
        Gate::authorize('viewAny', Role::class);

        // Fetch all roles
        $roles = Role::all();
        return response()->json($roles, 200);
    }

    public function store(StoreRoleRequest $request)
    {
        // Authorize the action
        Gate::authorize('create', Role::class);

        // Create the role
        $role = Role::create($request->validated());
        return response()->json(['message' => 'Role created successfully', 'role' => $role], 201);
    }

    public function show(Role $role)
    {
        // Authorize the action
        // Gate::authorize('view', $role);
        $permissions = $role->permissions; // Retrieve all permissions for this role
        return response()->json([$role], 200);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        // Authorize the action
        Gate::authorize('update', $role);

        // Update the role
        $role->update($request->validated());
        return response()->json(['message' => 'Role updated successfully', 'role' => $role], 200);
    }

    public function destroy(Role $role)
    {
        // Authorize the action
        Gate::authorize('delete', $role);

        // Delete the role
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully'], 200);
    }
}
