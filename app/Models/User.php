<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const ROLE_Head_UKPBJ       = 1;
    const ROLE_PPK              = 2;
    const ROLE_PP               = 3;
    const ROLE_HPS_TEAM         = 4;
    const ROLE_CONTRACT_TEAM    = 5;
    const ROLE_TECHNICAL_TEAM   = 6;
    const ROLE_UNIT             = 7;
    const ROLE_VerifAccount     = 8;
    
    const StringRole = ['Admin','PPK','Pp', 'Hps', 'Kontrak', 'Teknis', 'Unit', 'Siren'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'identity_number',
        'identity_type',
        'email',
        'password',
        'role',
        'status',
        'unit_id'
    ];

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
    ];

    public function units() {
        return $this->belongsTo(Unit::class,'unit_id');
    }
}
