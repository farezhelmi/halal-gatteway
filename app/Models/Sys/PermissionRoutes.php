<?php

namespace App\Models\Sys;

use App\Models\Ref\Status;
use App\Models\Sys\Routes;
use Illuminate\Database\Eloquent\Model;

class PermissionRoutes extends Model
{
    protected $table = 'sys_permission_routes';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'permission_id',
        'route_id',
        'created_at',
        'updated_at'
    ];

    public function route() {
        return $this->belongsTo(Routes::class, 'route_id', 'id');
    }
}
