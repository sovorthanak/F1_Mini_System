<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
// use Spatie\Permission\Middleware\RoleMiddleware;
// use Spatie\Permission\Middleware\PermissionMiddleware;

class RoleController extends Controller // implements HasMiddleware
{
    // public static function middleware(): array {
    //     return [
    //         'role:admin',
    //         new Middleware('permission:delete role', only: ['destroy']),
    //         new Middleware('permission:edit role', only: ['edit']),
    //         new Middleware('permission:create role', only: ['create', 'store']),
    //     ];
    // }

    public function index() {
        $roles = Role::all();
        return view('administration.roles.index', ['roles' => $roles]);
    }

    public function create() {
        return view('administration.roles.create');
    }

    public function store(Request $request) {

        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect('/administration/roles')->with('status','Permission Created Successfully!');
    }

    public function edit(Role $role) {
        return view('administration.roles.edit', ['role' => $role]);
    }

    public function update(Request $request, Role $role) {
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('roles', 'name')->ignore($role->id),
            ]
        ]);
    
        $role->update([
            'name' => $request->name
        ]);
    
        return redirect('/administration/roles/')->with('status', 'Permission Updated Successfully!');
    }
    
    public function destroy($roleId) {
        $role = Role::findOrFail($roleId);
        $role->delete();
        return redirect('/administration/roles')->with('status', 'Permission Deleted Successfully!');
    }

    public function showPermToRole($roleId) {

        $permissions = Permission::all();  // Corrected variable name to be plural for clarity
        $role = Role::findOrFail($roleId);
        $rolePerm = DB::table('role_has_permissions')
                        ->where('role_has_permissions.role_id', $role->id)
                        ->pluck('role_has_permissions.permission_id');
    
        return view('administration.roles.add-permission', [
            'role' => $role,
            'perm' => $permissions, // Corrected variable name to match the previous line
            'rolePerm' => $rolePerm
        ]);
    }

    public function givePermToRole(Request $request, $roleId) {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findorFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status', 'Permissions added to role!');
    }

}
