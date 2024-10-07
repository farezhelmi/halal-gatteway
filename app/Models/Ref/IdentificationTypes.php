<?php

namespace App\Models\Ref;

use Illuminate\Database\Eloquent\Model;

class IdentificationTypes extends Model
{
    protected $table = 'ref_identification_types';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'name',
    ];
}
