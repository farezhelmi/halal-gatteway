<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\Roles;
use App\Models\Usr\Users;
use Illuminate\Http\Request;
use App\Models\Sys\Permissions;
use App\Models\Sys\RolePermissions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccessController;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        $roles = Roles::where('status_id', '!=', 0)->orderBy('level', 'ASC')->get();

        return view('sys.roles.index', compact('roles'));
    }

    public function create()
    {
        $route = 'roles/store';
        $title = 'Add New Role';

        $role = new Roles();
        $permissions = Permissions::where('status_id', '=', 1)->orderBy('name', 'ASC')->pluck('name', 'id');

        return view('sys.roles.form', compact('title', 'route', 'role', 'permissions'));
    }

    public function store(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        $role = Roles::create([
            'name' => $request->name,
            'level' => $request->level,
            'status_id' => $request->status_id,
            'created_at' => NOW(),
        ]);

        for($i=0; $i < count($request->list_permission); $i++)
        {
            RolePermissions::create([
                'role_id' => $role->id,
                'permission_id' => $request->list_permission[$i],
                'created_at' => NOW(),
            ]);
        }
        
        return redirect()->route('roles/index')->with('success','Create new data successfully');
    }

    public function edit($id)
    {
        $route = 'roles/update';
        $title = 'Update Role';

        $role = Roles::where('id','=',$id)->first();
        $permissions = Permissions::where('status_id', '=', 1)->orderBy('name', 'ASC')->pluck('name', 'id');

        return view('sys.roles.form', compact('title', 'route', 'role', 'permissions'));
    }

    public function update(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        $request["name"] = $request->name;
        $request["level"] = $request->level;
        $request["status_id"] = $request->status_id;
        $request["updated_at"] = NOW();
        Roles::find($request->id)->update($request->all());

        // Update table sys_role_permissions ****************************************************************
        $role_permissions = RolePermissions::where('role_id', '=', $request->id)->get(); 
        foreach($role_permissions as $rp)
        {
            $matching = array_search($rp->permission_id, $request->list_permission);
            if($matching === False)
            {
                $delete_role_permission = RolePermissions::where('id', $rp->id)->delete();
            }
        }

        for($i=0; $i < count($request->list_permission); $i++)
        {
            $role_permission = RolePermissions::where([
                ['role_id', '=', $request->id], ['permission_id', '=', $request->list_permission[$i]]
            ])->first(); 
            
            if($role_permission == null) {
                RolePermissions::create([
                    'role_id' => $request->id,
                    'permission_id' => $request->list_permission[$i],
                    'created_at' => NOW(),
                ]);
            }
        }
        // **************************************************************************************************
      
        return redirect()->route('roles/index')->with('success','Update data successfully');
    }

    public function delete($id)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************
        
        Roles::find($id)->update([
            'status_id' => 0
        ]);

        return redirect()->route('roles/index')->with('success','Delete data successfully');
    }
}