<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'procure_acc_id',
        'name',
        'specification',
        'unit',
        'price',
        'total',
        'allocation',
        'source',
        'image',
    ];

    public function account (){
        return $this->hasMany(ProcurementAccounts::class);
    }
    
}