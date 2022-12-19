<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_total',
        'overheat',
        'overheat_percentage',
        'ppn',
        'file',
        'total',
    ];
}
