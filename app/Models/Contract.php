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
        'file_offer',

        'no_spk',
        'file_spk',
        'mak_code',
        'pic',
        'pic_position',
        'value_spk',
        'days',
        'date_start_spk',
        'date_end_spk',

        'no_sppbj',
        'file_sppbj',
        'date_sppbj',
        'purpose_sppbj',

        'no_sp',
        'file_sp',
        'date_sp',
        'paket_sp',
        'no_report',
        'payment',

        'no_bap',
        'file_bap',
        'date_bap',

        'no_bastp',
        'file_bastp',
        'date_bastp',
        
        'no_bp',
        'file_bp',
        'date_bp',

        'no_bahp',
        'file_bahp',
        'date_bahp',

        'no_bakn',
        'file_bakn',
        'date_bakn',

        'no_baep',
        'file_baep',
        'date_baep',
        'correction',
    ];
}
