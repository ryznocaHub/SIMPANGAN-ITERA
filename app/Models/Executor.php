<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Executor extends Model
{
    use HasFactory;

    protected $fillable = [
        'siren_approval',
        'siren_reject',
        'hps',
        'ppk',
        'pp',
        'contract',
        'technical',
        'treasurer',
        'treasurer_id',
        'executor',
        'executor_id',
        'person_responsible',
        'person_responsible_id',
    ];

    public function siren_approval(){
        return $this->hasOne(User::class,'id','siren_approval');
    }

    public function siren_reject(){
        return $this->hasOne(User::class,'id','siren_reject');
    }

    public function hps(){
        return $this->hasOne(User::class,'id','hps');
    }

    public function ppk(){
        return $this->hasOne(User::class,'id','ppk');
    }

    public function pp(){
        return $this->hasOne(User::class,'id','pp');
    }

    public function contract(){
        return $this->hasOne(User::class,'id','contract');
    }

    public function technical(){
        return $this->hasOne(User::class,'id','technical');
    }
}
