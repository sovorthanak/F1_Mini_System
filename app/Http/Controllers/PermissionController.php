<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;


class PermissionController extends Controller
{
    public function index() {
        $permission = Permission::all();
        return view('administration.permission.index', ['permission' => $permission]);
    }

    public function create() {
        return view('administration.permission.create');
    }

    public function store(Request $request) {

        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect('/administration/permissions')->with('status','Permission Created Successfully!');
    }

    public function edit(Permission $permission) {
        
        return view('administration.permission.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission) {
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('permissions', 'name')->ignore($permission->id),
            ]
        ]);
    
        $permission->update([
            'name' => $request->name
        ]);
    
        return redirect('/administration/permissions')->with('status', 'Permission Updated Successfully!');
    }
    

    public function destroy($permissionId) {
        $permission = Permission::findOrFail($permissionId);
        $permission->delete();
        return redirect('/administration/permissions')->with('status', 'Permission Deleted Successfully!');
    }
}
