<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AuthorizationController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('finetech.authorization.index', ["roles" => $roles]);
    }
    public function show(Role $role)
    {
        return view('finetech.authorization.show', ["role" => $role]);
    }
    public function create()
    {
        $permissionGroups = PermissionGroup::with('permissions')->get();
        return view('finetech.authorization.create', ['permissionGroups' => $permissionGroups]);
    }
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:roles,name",
            "permissions" => "array|exists:permissions,name"
        ]);

        try {
            $role = Role::create(["name" => $request->name]);
            if ($request->has("permissions")) {
                $role->syncPermissions($request->permissions);
            }
            toastr()->success("Role created successfully.");
            return redirect()->route("finetech.authorization.index");
        } catch (\Exception $e) {
            toastr()->error("Failed to create role. Please try again.");
            return redirect()->back();
        }
    }
    public function edit(Role $role)
    {
        $hasPermissions = $role->permissions->pluck('name')->toArray();
        $permissionGroups = PermissionGroup::with('permissions')->get();

        return view('finetech.authorization.edit', [
            "role" => $role,
            'permissionGroups' => $permissionGroups,
            'hasPermissions' => $hasPermissions
        ]);
    }
    public function update(Role $role, Request $request)
    {
        $request->validate([
            "name" => ["required", Rule::unique('roles', 'name')->ignore($role->id)],
            "permissions" => "array|exists:permissions,name"
        ]);

        try {
            $role->update(["name" => $request->name]);

            if ($request->has("permissions")) {
                $role->syncPermissions($request->permissions);
            }

            toastr()->success("Role Update successfully.");
            return redirect()->route("finetech.authorization.index");
        } catch (\Exception $e) {
            toastr()->error("Failed to  update role. Please try again.");
            return redirect()->back();
        }
    }
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            toastr()->success("Role deleted successfully.");
            return redirect()->route("finetech.authorization.index");
        } catch (\Exception $e) {
            toastr()->error("Failed to delete role. Please try again.");
            return redirect()->back();
        }
    }
}
