<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'no_spk',
        'value_spk',
        'date_spk',
        'no_sppbj',
        'date_sppbj',
        'purpose_sppbj',
        'no_report',
        'payment'
    ];
}
