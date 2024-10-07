<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Model;

class MenuRoles extends Model
{
    protected $table = 'sys_menu_roles';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'role_id',
        'menu_parent_id',
        'menu_1child_id',
        'menu_2child_id',
        'status_id',
        'created_at',
        'updated_at'
    ];
}
