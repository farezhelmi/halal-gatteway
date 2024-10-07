<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $table = 'log_activities';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'user_id',
        'path',
        'remarks',
        'created_at',
        'updated_at',
    ];
}
