<?php

namespace App\Models\Training;

use App\Models\Ref\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingType extends Model
{
    use HasFactory;

    protected $table = 'training_type';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'name',
        'status_id',
    ];

    public function status() {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
