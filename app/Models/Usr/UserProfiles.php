<?php

namespace App\Models\Usr;

use App\Models\Usr\Users;
use App\Models\Ref\IdentificationTypes;
use Illuminate\Database\Eloquent\Model;

class UserProfiles extends Model
{
    protected $table = 'usr_user_profiles';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'identification_type_id',
        'identification_card',
        'phone_home',
        'phone_mobile',
        'path_avatar',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public function user() {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }

    public function identification() {
        return $this->belongsTo(IdentificationTypes::class, 'identification_type_id', 'id');
    }
}
