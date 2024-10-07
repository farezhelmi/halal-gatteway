<?php

namespace App\Http\Controllers;

use App\Models\Usr\Users;
use App\Models\Sys\RoleUsers;
use App\Models\Sys\Permissions;
use App\Models\Sys\RolePermissions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
