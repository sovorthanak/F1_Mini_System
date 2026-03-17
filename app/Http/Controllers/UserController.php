<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return view('administration.users.index', ['users' => $users]);
    }

    public function create() {

        $roles = Role::pluck('name', 'name')->all();
        return view('administration.users.create', ['roles' => $roles]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:225|unique:users,name',
            'email' => 'required|email|max:225|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]); 

        $user->syncRoles($request->roles);

        return redirect('/administration/users')->with('status', 'User created successfully with roles!');
    }

    public function edit(User $user) {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('administration.users.edit', ['user' => $user, 'roles' => $roles, 'userRoles' => $userRoles]);
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name' => 'required|string|max:225',
            'password' => 'nullable|string|min:8',
            'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if(!empty($request->password)){
            $data += [
                'password' => Hash::make($request->password),
            ];
        }

        $user->update($data); 
        $user->syncRoles($request->roles);

        return redirect('administration/users')->with('status', 'User Updated successfully with roles!');
    }

    public function destroy($userId) {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect('/administration/users')->with('status', 'User Deleted Successfuly!');
    }

}
