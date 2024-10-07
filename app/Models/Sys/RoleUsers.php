<?php

namespace App\Models\Sys;

use App\Models\Sys\Roles;
use App\Models\Usr\Users;
use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
{
    protected $table = 'sys_role_users';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'role_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }

    public function role() {
        return $this->belongsTo(Roles::class, 'role_id', 'id');
    }
}
