<?php

namespace App\Models\Sys;

use App\Models\Ref\Status;
use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
    protected $table = 'sys_routes';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];
}
