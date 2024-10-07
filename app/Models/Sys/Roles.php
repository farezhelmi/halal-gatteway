<?php

namespace App\Models\Sys;

use App\Models\Ref\Status;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'sys_roles';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'code',
        'short',
        'name',
        'level',
        'status_id',
        'created_at',
        'updated_at'
    ];

    public function status() {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
