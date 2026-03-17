<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserGroupsController extends Controller
{

    public function index()
    {
        $roles = Role::with('users')->get(); // loads each role and its assigned users
        return view('administration.user_groups.index', compact('roles'));
    }

}
