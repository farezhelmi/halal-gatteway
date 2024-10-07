<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\Roles;
use Illuminate\Http\Request;
use App\Models\Sys\MenuRoles;
use App\Models\Sys\Menu1Childs;
use App\Models\Sys\Menu2Childs;
use App\Models\Sys\MenuParents;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccessController;

class MenuController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu_parents = MenuParents::where('status_id', '!=', 0)->orderBy('sort', 'ASC')->get();
        
        return view('sys.menu.index', compact('menu_parents'));
    }

    public function create()
    {
        $title = 'ADD NEW MENU';
        $route = 'menu/store';
        $action = 'create';

        $parents = MenuParents::where('status_id', '=', 1)->orderBy('sort', 'ASC')->get();
        $roles = Roles::where('status_id', '=', 1)->orderBy('id', 'ASC')->pluck('name', 'id');

        $root = '';
        $model = new MenuParents();

        return view('sys.menu.form', compact('title', 'route', 'action', 'parents', 'roles', 'root', 'model'));
    }

    public function store(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        if($request->parent == 'ROOT') 
        {
            $menu_parent = MenuParents::create([
                'sort' => $request->sort,
                'title' => $request->title,
                'icon' => $request->icon,
                'url' => $request->url,
                'parameter' => $request->parameter,
                'status_id' => $request->status_id,
                'created_at' => NOW(),
            ]);

            for($i=0; $i < count($request->roles); $i++)
            {
                MenuRoles::create([
                    'role_id' => $request->roles[$i],
                    'menu_parent_id' => $menu_parent->id,
                    'status_id' => $request->status_id,
                    'created_at' => NOW(),
                ]);
            }
        }
        elseif(substr($request->parent, 0, 6) == 'parent') 
        {
            $menu_1child = Menu1Childs::create([
                'parent_id' => substr($request->parent, 7),
                'sort' => $request->sort,
                'title' => $request->title,
                'icon' => $request->icon,
                'url' => $request->url,
                'parameter' => $request->parameter,
                'status_id' => $request->status_id,
                'created_at' => NOW(),
            ]);

            for($i=0; $i < count($request->roles); $i++)
            {
                MenuRoles::create([
                    'role_id' => $request->roles[$i],
                    'menu_parent_id' => substr($request->parent, 7),
                    'menu_1child_id' => $menu_1child->id,
                    'status_id' => $request->status_id,
                    'created_at' => NOW(),
                ]);
            }
        }
        else
        {
            $menu_1child = Menu1Childs::where('id', '=', substr($request->parent, 7))->first();

            $menu_2child = Menu2Childs::create([
                'parent_id' => $menu_1child->parent_id,
                'child1_id' => $menu_1child->id,
                'sort' => $request->sort,
                'title' => $request->title,
                'icon' => $request->icon,
                'url' => $request->url,
                'parameter' => $request->parameter,
                'status_id' => $request->status_id,
                'created_at' => NOW(),
            ]);

            for($i=0; $i < count($request->roles); $i++)
            {
                MenuRoles::create([
                    'role_id' => $request->roles[$i],
                    'menu_parent_id' => $menu_1child->parent_id,
                    'menu_1child_id' => $menu_1child->id,
                    'menu_2child_id' => $menu_2child->id,
                    'status_id' => $request->status_id,
                    'created_at' => NOW(),
                ]);
            }
        }
        
        return redirect()->route('menu/index')->with('success','Create new menu successfully');
    }

    public function editparent($id)
    {
        $title = 'EDIT MENU INFORMATION';
        $route = 'menu/update';
        $action = 'edit-parent';

        $parents = MenuParents::where('status_id', '=', 1)->orderBy('sort', 'ASC')->get();
        $roles = Roles::where('status_id', '=', 1)->orderBy('id', 'ASC')->pluck('name', 'id');

        $root = 'selected="selected"';
        $model = MenuParents::find($id);

        return view('sys.menu.form', compact('title', 'route', 'action', 'parents', 'roles', 'root', 'model'));
    }

    public function editchild1($id)
    {
        $title = 'EDIT MENU INFORMATION';
        $route = 'menu/update';
        $action = 'edit-child1';

        $parents = MenuParents::where('status_id', '=', 1)->orderBy('sort', 'ASC')->get();
        $roles = Roles::where('status_id', '=', 1)->orderBy('id', 'ASC')->pluck('name', 'id');

        $root = '';
        $model = Menu1Childs::find($id);

        return view('sys.menu.form', compact('title', 'route', 'action', 'parents', 'roles', 'root', 'model'));
    }

    public function editchild2($id)
    {
        $title = 'EDIT MENU INFORMATION';
        $route = 'menu/update';
        $action = 'edit-child2';

        $parents = MenuParents::where('status_id', '=', 1)->orderBy('sort', 'ASC')->get();
        $roles = Roles::where('status_id', '=', 1)->orderBy('id', 'ASC')->pluck('name', 'id');

        $root = '';
        $model = Menu2Childs::find($id);

        return view('sys.menu.form', compact('title', 'route', 'action', 'parents', 'roles', 'root', 'model'));
    }

    public function update(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        if($request->action == 'edit-parent') 
        {
            $menu_parent = MenuParents::find($request->id)->update([
                'sort' => $request->sort,
                'title' => $request->title,
                'icon' => $request->icon,
                'url' => $request->url,
                'parameter' => $request->parameter,
                'status_id' => $request->status_id,
                'updated_at' => NOW(),
            ]);

            // Update table sys_menu_roles **********************************************************************
            $menu_roles = MenuRoles::where('menu_parent_id', '=', $request->id)->get(); 
            foreach($menu_roles as $mr)
            {
                $matching = array_search($mr->role_id, $request->roles);
                if($matching === False)
                {
                    $delete_menu_role = MenuRoles::where('id', $mr->id)->delete();
                }
            }

            for($i=0; $i < count($request->roles); $i++)
            {
                $menu_role = MenuRoles::where([
                    ['menu_parent_id', '=', $request->id], ['role_id', '=', $request->roles[$i]]
                ])->first(); 
                
                if($menu_role == null) {
                    MenuRoles::create([
                        'role_id' => $request->roles[$i],
                        'menu_parent_id' => $request->id,
                        'status_id' => $request->status_id,
                        'created_at' => NOW(),
                    ]);
                }
            }
            // **************************************************************************************************
        }
        elseif($request->action == 'edit-child1') 
        {
            if(substr($request->parent, 0,6) == "child1")
            {
                // Delete Menu Child 1 *******************************************************
                Menu1Childs::find($request->id)->delete();
                $menu_roles = MenuRoles::where('menu_1child_id', '=', $request->id)->get();
                foreach($menu_roles as $mr)
                {
                    MenuRoles::where('id', $mr->id)->delete();
                }
                // End Delete Menu Child 1 ***************************************************

                $menu_1child = Menu1Childs::where('id', '=', substr($request->parent, 7))->first();
                $menu_2child = Menu2Childs::create([
                    'parent_id' => $menu_1child->parent_id,
                    'child1_id' => $menu_1child->id,
                    'sort' => $request->sort,
                    'title' => $request->title,
                    'icon' => $request->icon,
                    'url' => $request->url,
                    'parameter' => $request->parameter,
                    'status_id' => $request->status_id,
                    'created_at' => NOW(),
                ]);
    
                for($i=0; $i < count($request->roles); $i++)
                {
                    MenuRoles::create([
                        'role_id' => $request->roles[$i],
                        'menu_parent_id' => $menu_1child->parent_id,
                        'menu_1child_id' => $menu_1child->id,
                        'menu_2child_id' => $menu_2child->id,
                        'status_id' => $request->status_id,
                        'created_at' => NOW(),
                    ]);
                }
            }
            else
            {
                $menu_1child = Menu1Childs::find($request->id)->update([
                    'parent_id' => substr($request->parent, 7),
                    'sort' => $request->sort,
                    'title' => $request->title,
                    'icon' => $request->icon,
                    'url' => $request->url,
                    'parameter' => $request->parameter,
                    'status_id' => $request->status_id,
                    'created_at' => NOW(),
                ]);

                // Update table sys_menu_roles **********************************************************************
                $menu_roles = MenuRoles::where('menu_1child_id', '=', $request->id)->get(); 
                foreach($menu_roles as $mr)
                {
                    $matching = array_search($mr->role_id, $request->roles);
                    if($matching === False)
                    {
                        $delete_menu_role = MenuRoles::where('id', $mr->id)->delete();
                    }
                    else
                    {
                        if($mr->menu_parent_id != substr($request->parent, 7))
                        {
                            $delete_menu_role = MenuRoles::where('id', $mr->id)->delete();
                        }
                    }
                }

                for($i=0; $i < count($request->roles); $i++)
                {
                    $menu_role = MenuRoles::where([
                        ['menu_1child_id', '=', $request->id], ['role_id', '=', $request->roles[$i]]
                    ])->first(); 
                    
                    if($menu_role == null) {
                        MenuRoles::create([
                            'role_id' => $request->roles[$i],
                            'menu_parent_id' => substr($request->parent, 7),
                            'menu_1child_id' => $request->id,
                            'status_id' => $request->status_id,
                            'created_at' => NOW(),
                        ]);
                    }
                }
                // **************************************************************************************************
            }
        }
        elseif($request->action == 'edit-child2') 
        {
            if(substr($request->parent, 0,6) == "parent")
            {
                // Delete Menu Child 2 *******************************************************
                Menu2Childs::find($request->id)->delete();
                $menu_roles = MenuRoles::where('menu_2child_id', '=', $request->id)->get();
                foreach($menu_roles as $mr)
                {
                    MenuRoles::where('id', $mr->id)->delete();
                }
                // End Delete Menu Child 2 ***************************************************

                $menu_1child = Menu1Childs::create([
                    'parent_id' => substr($request->parent, 7),
                    'sort' => $request->sort,
                    'title' => $request->title,
                    'icon' => $request->icon,
                    'url' => $request->url,
                    'parameter' => $request->parameter,
                    'status_id' => $request->status_id,
                    'created_at' => NOW(),
                ]);

                for($i=0; $i < count($request->roles); $i++)
                {
                    MenuRoles::create([
                        'role_id' => $request->roles[$i],
                        'menu_parent_id' => substr($request->parent, 7),
                        'menu_1child_id' => $menu_1child->id,
                        'status_id' => $request->status_id,
                        'created_at' => NOW(),
                    ]);
                }
            }
            else
            {
                $menu_1child = Menu1Childs::where('id', '=', substr($request->parent, 7))->first();
                $menu_2child = Menu2Childs::find($request->id)->update([
                    'parent_id' => $menu_1child->parent_id,
                    'child1_id' => $menu_1child->id,
                    'sort' => $request->sort,
                    'title' => $request->title,
                    'icon' => $request->icon,
                    'url' => $request->url,
                    'parameter' => $request->parameter,
                    'status_id' => $request->status_id,
                    'created_at' => NOW(),
                ]);

                // Update table sys_menu_roles **********************************************************************
                $menu_roles = MenuRoles::where('menu_2child_id', '=', $request->id)->get(); 
                foreach($menu_roles as $mr)
                {
                    $matching = array_search($mr->role_id, $request->roles);
                    if($matching === False)
                    {
                        $delete_menu_role = MenuRoles::where('id', $mr->id)->delete();
                    }
                    else
                    {
                        if($mr->menu_1child_id != $menu_1child->id)
                        {
                            $delete_menu_role = MenuRoles::where('id', $mr->id)->delete();
                        }
                        elseif($mr->menu_parent_id != $menu_1child->parent_id)
                        {
                            $delete_menu_role = MenuRoles::where('id', $mr->id)->delete();
                        }
                    }
                }

                for($i=0; $i < count($request->roles); $i++)
                {
                    $menu_role = MenuRoles::where([
                        ['menu_2child_id', '=', $request->id], ['role_id', '=', $request->roles[$i]]
                    ])->first(); 
                    
                    if($menu_role == null) {
                        MenuRoles::create([
                            'role_id' => $request->roles[$i],
                            'menu_parent_id' => $menu_1child->parent_id,
                            'menu_1child_id' => $menu_1child->id,
                            'menu_2child_id' => $request->id,
                            'status_id' => $request->status_id,
                            'created_at' => NOW(),
                        ]);
                    }
                }
                // **************************************************************************************************
            }
        }
        
        return redirect()->route('menu/index')->with('success','Update menu information successfully');
    }

    public function deleteparent($id)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        MenuParents::find($id)->update([
            'status_id' => 0
        ]);
        
        return redirect()->route('menu/index')->with('success','Delete data successfully');
    }

    public function deletechild1($id)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        Menu1Childs::find($id)->update([
            'status_id' => 0
        ]);
        
        return redirect()->route('menu/index')->with('success','Delete data successfully');
    }

    public function deletechild2($id)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        Menu2Childs::find($id)->update([
            'status_id' => 0
        ]);
        
        return redirect()->route('menu/index')->with('success','Delete data successfully');
    }
}