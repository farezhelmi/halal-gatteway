<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'sys_settings';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'title',
        'title_favicon',
        'favicon_path',
        'logo_path',
        'logo_login_path',
        'created_at',
        'updated_at'
    ];
}
