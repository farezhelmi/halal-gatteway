<?php

namespace App\Models\Sys;

use App\Models\Ref\Status;
use Illuminate\Database\Eloquent\Model;

class MenuParents extends Model
{
    protected $table = 'sys_menu_parents';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'sort',
        'title',
        'icon',
        'url',
        'parameter',
        'status_id',
        'created_at',
        'updated_at'
    ];

    public function status() {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
