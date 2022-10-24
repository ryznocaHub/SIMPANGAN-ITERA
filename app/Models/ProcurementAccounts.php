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
       'user_id',
            'supplier_id',
            'contract_id',
            'executor_id',
            'timeline_id',
            'budget_plan_id',
            'estimate_id',
            'realized_id',
            'name',
            'account',
            'rup_code',
            'year',
            'unit',
            'category',
            'status',
            'comment',
    ];

    public function items() {
        return $this->hasMany(ProcurementItem::class, 'procure_acc_id');
    }

    public function executor(){
        return $this->hasOne(Executor::class,'id','executor_id');
    }

    public function suppliers(){
        return $this->hasOne(Supplier::class,'id','supplier_id');
    }

    public function contract(){
        return $this->hasOne(Contract::class,'id','contract_id');
    }

    public function timeline(){
        return $this->hasOne(Timeline::class,'id','timeline_id');
    }
    
    public function budget_plan(){
        return $this->hasOne(BudgetPlan::class,'id','budget_plan_id');
    }
    
    public function estimate(){
        return $this->hasOne(Estimate::class,'id','estimate_id');
    }
}
