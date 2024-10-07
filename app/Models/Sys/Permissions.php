<?php

namespace App\Models\Sys;

use App\Models\Ref\Status;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table = 'sys_permissions';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'name',
        'method',
        'route',
        'status_id',
        'created_at',
        'updated_at'
    ];

    public function status() {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
