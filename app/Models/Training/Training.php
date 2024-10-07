<?php

namespace App\Models\Training;

use App\Models\Ref\Status;
use App\Models\Trainer\Trainer;
use App\Models\Attendance\Attendance;
use App\Models\Training\TrainingType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'title',
        'training_date',
        'training_type_id',
        'status_id',
        'created_by', 
        'updated_by'
    ];

    protected $casts = [
        'training_date' => 'datetime',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function training() {
        return $this->belongsTo(TrainingType::class, 'training_type_id', 'id');
    }
}
