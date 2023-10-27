<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function role_manager(){
        $permissions = Permission::all();
        $roles = Role::all();
        $users = User::all();
        return view('admin.role.index', [
            'permissions'=> $permissions,
            'roles'=> $roles,
            'users'=> $users,
        ]);
    }
    function permission_store(Request $request){
        Permission::create(['name' => $request->permission_name]);
        return back();
    }
    function role_store(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);
        return back();
    }

    function assign_role(Request $request){
        $user = User::find($request->user_id);
        $user->assignRole($request->role_id);
        return back();
    }

    function remove_user_role($user_id){
        $user = User::find($user_id);
        $user->syncRoles([]);
        $user->syncPermissions([]);
        return back();
    }
    function remove_role_permission($role_id){
        $role = Role::find($role_id);
        $role->syncPermissions([]);
        $role->delete();
        return back();
    }
}
