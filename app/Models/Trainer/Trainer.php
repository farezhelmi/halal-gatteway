<?php

namespace App\Models\Trainer;

use App\Models\Usr\Users;
use App\Models\Ref\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identification_type_id',
        'identification_no',
        'email',
        'gender',
        'phone_no',
        'certificate',
        'created_by',
        'updated_by',
        'status_id',
        'created_at',
        'updated_at',
    ];

    // Define relationship with the User model
    public function creator()
    {
        return $this->belongsTo(Users::class, 'created_by');
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
