<?php
use App\Models\Sys\MenuRoles;
use App\Models\Sys\Menu1Childs;
use App\Models\Sys\Menu2Childs;
use App\Models\Sys\MenuParents;

$menu_parents = MenuParents::where('status_id', '=', 1)->orderBy('sort', 'ASC')->get();

$parentID = null;
$child1ID = null;
$child2ID = null;

$active_menu = Menu2Childs::where('url', '=', Route::currentRouteName())->first();
if($active_menu == null)
{
    $active_menu = Menu1Childs::where('url', '=', Route::currentRouteName())->first();
    if($active_menu == null)
    {
        $active_menu = MenuParents::where('url', '=', Route::currentRouteName())->first();
        if($active_menu != null)
        {
            $parentID = $active_menu->id;
        }
    }
    else
    {
        $parentID = $active_menu->parent_id;
        $child1ID = $active_menu->id;
    }
}
else
{
    $parentID = $active_menu->parent_id;
    $child1ID = $active_menu->child1_id;
    $child2ID = $active_menu->id;
}
?>

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- {{ (Request::is('menu/index') ? 'MASUK' : 'TAK MASUK')  }} -->
        <!-- {{ Route::currentRouteName() }} -->
        @if(count($menu_parents) > 0)
            @foreach($menu_parents as $parent)
                <li class="nav-item <?php if($parentID == $parent->id) { echo 'menu-open'; } ?>">
                    <?php 
                        $parent_access = null;
                        foreach ($roleUser as $ru) {
                            $menu_role = MenuRoles::where([
                                ['status_id', '=', 1],
                                ['menu_parent_id', '=', $parent->id],
                                ['role_id', '=', $ru->role_id]
                            ])->first();

                            if($menu_role != null) {
                                $parent_access = "YES";
                            }
                        }
                    ?>
                    @if($parent_access == "YES")
                        <?php $menu_1childs = Menu1Childs::where([['status_id', '=', 1], ['parent_id', '=', $parent->id]])->orderBy('sort', 'ASC')->get();  ?>
                        @if(count($menu_1childs) > 0)
                            <a class="nav-link <?php if($parentID == $parent->id) { echo 'active'; } ?>"><i class="nav-icon {{ $parent->icon }}"></i> <p style="font-size:14px;">{{ $parent->title }} <i class="right fas fa-angle-left"></i></p></a>
                            <ul class="nav nav-treeview">
                                @if(count($menu_1childs) > 0)
                                    @foreach($menu_1childs as $child_1)
                                        <?php 
                                            $child1_access = null;
                                            foreach ($roleUser as $ru) {
                                                $menu_role = MenuRoles::where([
                                                    ['status_id', '=', 1],
                                                    ['menu_1child_id', '=', $child_1->id],
                                                    ['role_id', '=', $ru->role_id]
                                                ])->first();

                                                if($menu_role != null) {
                                                    $child1_access = "YES";
                                                }
                                            }
                                        ?>
                                        @if($child1_access == "YES")
                                            <?php $menu_2childs = Menu2Childs::where([['status_id', '=', 1], ['parent_id', '=', $parent->id], ['child1_id', '=', $child_1->id]])->orderBy('sort', 'ASC')->get();  ?>
                                            @if(count($menu_2childs) > 0)
                                                <li class="nav-item <?php if($child1ID == $child_1->id) { echo 'menu-open'; } ?>">
                                                    <a class="nav-link">&emsp;<i class="{{ $child_1->icon }}"></i> <p style="font-size:14px;">{{ $child_1->title }} <i class="right fas fa-angle-left"></i></p></a>
                                                    <ul class="nav nav-treeview">
                                                        @foreach($menu_2childs as $child_2)
                                                            <?php 
                                                                $child2_access = null;
                                                                foreach ($roleUser as $ru) {
                                                                    $menu_role = MenuRoles::where([
                                                                        ['status_id', '=', 1],
                                                                        ['menu_1child_id', '=', $child_1->id],
                                                                        ['menu_2child_id', '=', $child_2->id],
                                                                        ['role_id', '=', $ru->role_id]
                                                                    ])->first();

                                                                    if($menu_role != null) {
                                                                        $child2_access = "YES";
                                                                    }
                                                                }
                                                            ?>
                                                            @if($child2_access == "YES")
                                                                <li class="nav-item"><a href="{{ route($child_2->url,[$child_2->parameter]) }}" class="nav-link <?php if($child2ID == $child_2->id) { echo 'active'; } ?>">&emsp;&emsp;<i class="{{ $child_2->icon }}"></i> <p style="font-size:14px;">{{ $child_2->title }}</p></a></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li class="nav-item"><a href="{{ route($child_1->url,[$child_1->parameter]) }}" class="nav-link <?php if($child1ID == $child_1->id) { echo 'active'; } ?>">&emsp;<i class="{{ $child_1->icon }}"></i> <p style="font-size:14px;">{{ $child_1->title }}</p></a></li>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        @else
                            <?php
                                $current_controller = strtok(Route::currentRouteName(), '/');
                                $menu_controller = strtok($parent->url, '/');
                                
                                $parent_active = null;
                                if($current_controller == $menu_controller && $current_controller != '') { $parent_active = 'active'; }
                            ?>
                            @if($parent->url == '#')
                                <a class="nav-link <?php if($parentID == $parent->id || $parent_active == 'active') { echo 'active'; } ?>"><i class="nav-icon {{ $parent->icon }}"></i> <p style="font-size:14px;">{{ $parent->title }}</p></a>
                            @else
                                <a href="{{ route($parent->url,[$parent->parameter]) }}" class="nav-link <?php if($parentID == $parent->id || $parent_active == 'active') { echo 'active'; } ?>"><i class="nav-icon {{ $parent->icon }}"></i> <p style="font-size:14px;">{{ $parent->title }}</p></a>
                            @endif
                            
                        @endif
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
</nav>