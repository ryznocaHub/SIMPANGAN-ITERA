<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementAccounts extends Model
{
    const is_UploadImageItem        = 1;
    const is_ApprovalSiren          = 2;
    const is_RABReject              = 3;
    const is_ChoosingHpsExecutor    = 4;
    const is_CreateHPS              = 5;
    const is_ApprovalHPS            = 6;
    const is_HPSReject              = 7;
    const is_ChoosingSupplier       = 8;
    const is_CreateContract         = 9;
    const is_CheckingRealItems      = 10;

    const status = [4,4,8,5,9,10,1,2];
    // const status = [ is_ChoosingHpsExecutor, $is_ChoosingHpsExecutor , $is_ChoosingSupplier, $is_CreateHPS, $is_CreateContract, $is_CheckingRealItems ,$is_UploadImageItem];

    const UPDATED_AT = null;
    const CREATED_AT = null;
    use HasFactory;

    protected $fillable = [
        'name',
        'account',
        'unit',
        'year',
        'category',
        'hps_executor',
        'executor',              
        'executor_id',           
        'contract_id',           
        'person_responsible',    
        'person_responsible_id', 
        'PPK',                   
        'PPK_id',                
        'treasurer',             
        'treasurer_id',          
        'PPN',                   
        'sub_total',             
        'estimate_sub_total',             
        'total',      
        'estimate_total',      
        'provit', 
        'user_id',
        'supplier_id',
        'comment',
        'status',
        'procurement_start',
        'rab_submitted',
        'hps_submitted',
        'supplier_submitted',
        'procurement_end',
    ];

    public function items() {
        return $this->hasMany(ProcurementItem::class, 'procure_acc_id');
    }

    public function hpsexecutor(){
        return $this->hasOne(User::class,'id','hps_executor');
    }

    public function suppliers(){
        return $this->hasOne(Supplier::class,'id','supplier_id');
    }
}
