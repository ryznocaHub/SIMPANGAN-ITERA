<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementAccounts extends Model
{
    const is_UploadImageItem    = 1;
    const is_HPSChecking        = 2;

    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'year',
        'category',
        'executor',              
        'executor_id',           
        'person_responsible',    
        'person_responsible_id', 
        'PPK',                   
        'PPK_id',                
        'treasurer',             
        'treasurer_id',          
        'PPN',                   
        'sub_total',             
        'total',       
        'user_id',
        'supplier_id',
        'rab_file',
        'boq_file',
        'comment',
        'status'
    ];

    public function items() {
        return $this->hasMany(ProcurementItem::class, 'procure_acc_id');
    }
}
