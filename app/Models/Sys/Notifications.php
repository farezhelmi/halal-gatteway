<?php

namespace App\Models\Sys;

use App\Models\Usr\Users;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = 'sys_notifications';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'descriptions',
        'url_redirect',
        'is_read',
        'created_at',
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }
}
