<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\Routes;
use Illuminate\Http\Request;
use App\Models\Sys\Permissions;
use App\Http\Controllers\Controller;
use App\Models\Sys\PermissionRoutes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        $permissions = Permissions::where([['status_id', '!=', 0]])->get();

        return view('sys.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $route = 'permissions/store';
        $title = 'Add New Permission';

        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $value) 
        {
            $checkRoute = Routes::where('name', '=', $value->getName())->first();
            if($checkRoute == null && $value->getName() != null)
            {
                $route_create = Routes::create([
                    'name' => $value->getName(),
                    'created_at' => NOW(),
                ]);
            }
        }

        $permission = new Permissions();
        $routes = Routes::where('id','>',4)->pluck('name', 'id');

        return view('sys.permissions.form', compact('title', 'route', 'permission', 'routes'));
    }

    public function store(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        $permission = Permissions::create([
            'name' => $request->name,
            'status_id' => $request->status_id,
            'created_at' => NOW(),
        ]);

        for($i=0; $i < count($request->list_route); $i++)
        {
            PermissionRoutes::create([
                'permission_id' => $permission->id,
                'route_id' => $request->list_route[$i],
                'created_at' => NOW(),
            ]);
        }

        return redirect()->route('permissions/index')->with('success','Create new data successfully');
    }

    public function edit($id)
    {
        $route = 'permissions/update';
        $title = 'Add New Permission';

        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $value) 
        {
            $checkRoute = Routes::where('name', '=', $value->getName())->first();
            if($checkRoute == null && $value->getName() != null)
            {
                $route_create = Routes::create([
                    'name' => $value->getName(),
                    'created_at' => NOW(),
                ]);
            }
        }

        $permission = Permissions::where('id','=',$id)->first();
        $routes = Routes::where('id','>',4)->pluck('name', 'id');

        return view('sys.permissions.form', compact('title', 'route', 'permission', 'routes'));
    }

    public function update(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************
        
        $request["name"] = $request->name;
        $request["status_id"] = $request->status_id;
        $request["updated_at"] = NOW();
        Permissions::find($request->id)->update($request->all());

        // Update table sys_permission_routes ***************************************************************
        $permission_routes = PermissionRoutes::where('permission_id', '=', $request->id)->get(); 
        foreach($permission_routes as $pr)
        {
            $matching = array_search($pr->route_id, $request->list_route);
            if($matching === False)
            {
                $delete_permission_route = PermissionRoutes::where('id', $pr->id)->delete();
            }
        }

        for($i=0; $i < count($request->list_route); $i++)
        {
            $permission_route = PermissionRoutes::where([
                ['permission_id', '=', $request->id], ['route_id', '=', $request->list_route[$i]]
            ])->first(); 
            
            if($permission_route == null) {
                PermissionRoutes::create([
                    'permission_id' => $request->id,
                    'route_id' => $request->list_route[$i],
                    'created_at' => NOW(),
                ]);
            }
        }
        // **************************************************************************************************
      
        return redirect()->route('permissions/index')->with('success','Update data successfully');
    }

    public function delete($id)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************
        
        Permissions::find($id)->update([
            'status_id' => 0
        ]);

        return redirect()->route('permissions/index')->with('success','Delete data successfully');
    }
}