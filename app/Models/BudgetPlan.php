<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPlan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sub_total',
        'overheat',
        'ppn',
        'total',
    ];
}
