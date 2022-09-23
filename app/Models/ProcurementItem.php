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
        'estimate_price',
        'total',
        'estimate_total',
        'allocation',
        'source',
        'estimate_source',
        'estimate_file',
        'image',
        'status'
    ];

    public function account (){
        return $this->belongsTo(ProcurementAccounts::class,'procure_acc_id');
    }
    
}