<?php

namespace App\Models\Sys;

use App\Models\Sys\Permissions;
use Illuminate\Database\Eloquent\Model;

class RolePermissions extends Model
{
    protected $table = 'sys_role_permissions';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'role_id',
        'permission_id',
        'created_at',
        'updated_at'
    ];

    public function permission() {
        return $this->belongsTo(Permissions::class, 'permission_id', 'id');
    }
}
