<?php

namespace App\Models\Usr;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Sys\Roles;
use App\Models\Usr\Users;
use App\Models\Ref\Status;
use App\Models\Usr\UserProfiles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usr_users';
    
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'username',
        'email',
        'password',
        'role_id',
        'status_id',
        'email_verified',
        'token',
        'first_login',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'login_last',
        'login_at',
    ];

    public function profile() {
        return $this->belongsTo(UserProfiles::class, 'id', 'user_id');
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function role() {
        return $this->belongsTo(Roles::class, 'role_id', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
