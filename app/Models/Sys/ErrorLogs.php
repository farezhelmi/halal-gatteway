<?php

namespace App\Models\Sys;

use App\Models\Ref\Status;
use Illuminate\Database\Eloquent\Model;

class ErrorLogs extends Model
{
    protected $table = 'sys_error_logs';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'url',
        'user_id',
        'log',
        'created_at',
        'updated_at'
    ];
}
