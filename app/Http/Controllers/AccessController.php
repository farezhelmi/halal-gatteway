<?php

namespace App\Http\Controllers;

use App\Models\Usr\Users;
use Illuminate\Http\Request;
use App\Models\Sys\RoleUsers;
use App\Models\Sys\Permissions;
use App\Models\Sys\RolePermissions;
use App\Http\Controllers\Controller;
use App\Models\Sys\PermissionRoutes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AccessController extends Controller
{
    public function permission()
    {
        $access = 0;
        $cur_route = Route::getCurrentRoute()->getName();
        $role_users = RoleUsers::where('user_id', '=', Auth::id())->get();

        if(count($role_users) > 0) 
        {
            foreach ($role_users as $key => $roleUser) 
            {
                $role_permissions = RolePermissions::where('role_id', '=', $roleUser->role_id)->get();

                if(count($role_permissions) > 0)
                {
                    foreach ($role_permissions as $key => $rolePermission) 
                    {
                        $permission = Permissions::where('id', '=', $rolePermission->permission_id)->first();

                        if($permission != null)
                        {
                            $permissionRoutes = PermissionRoutes::where('permission_id','=',$permission->id)->get();
                            foreach ($permissionRoutes as $key => $route) 
                            {
                                if($route->route->name == $cur_route) 
                                {
                                    $access = 1;
                                }
                            }
                        }
                    }
                }
            }
        }

        if($access == 0){
            print('<center>
                <div class="text-wrapper">
                    <div class="title" data-content="404">
                        403 - ACCESS DENIED
                    </div>
                    <div class="subtitle">
                        Oops, You don`t have permission to access this page.
                    </div>
                </div>

                </center> 
                <style>
                body {
                    background-color: #d1dced; 
                    height: 100%;
                    padding: 10px;
                }
                .title {
                    font-size: 40px;
                    font-weight: 700;
                    color: #fa0000;
                }
                .text-wrapper {
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                }
                .subtitle {
                    font-size: 30px;
                    font-weight: 700;
                    color: #050505;
                }
            </style>');  
            
            die;
        }
    }
}