<?php

namespace App\Models\Ref;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'ref_status';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'name',
        'color'
    ];
}
