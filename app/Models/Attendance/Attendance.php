<?php

namespace App\Models\Attendance;

use App\Models\Trainer\Trainer;
use App\Models\Training\Training;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id',
        'trainer_id', 
        'name', 
        'army_id', 
        'identification_no', 
        'email', 
        'gender', 
        'phone_no'
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
}
