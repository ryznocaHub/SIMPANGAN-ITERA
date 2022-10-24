<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'offer',
        'date_offer',
        'no_offer',
        'no_spk',
        'mak_code',
        'pic',
        'pic_position',
        'value_spk',
        'days',
        'date_start_spk',
        'date_end_spk',
        'no_sppbj',
        'date_sppbj',
        'purpose_sppbj',
        'no_sp',
        'date_sp',
        'paket_sp',
        'no_report',
        'payment',
        'no_bastp',
        'date_bastp',
        'no_bap',
        'date_bap',
    ];
}
