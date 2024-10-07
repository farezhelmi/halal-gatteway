<?php

namespace App\Models\Sys;

use App\Models\Ref\Status;
use Illuminate\Database\Eloquent\Model;

class Menu2Childs extends Model
{
    protected $table = 'sys_menu_2childs';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'parent_id',
        'child1_id',
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
