<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'procurement_start',
        'rab_submitted',
        'siren_approved',
        'rab_reupload',
        'siren_rejected',
        'hps_selected',
        'hps_submitted',
        'hps_rejected',
        'hps_approved',
        'supplier_selected',
        'sppbj_created',
        'spk_created',
        'bastp_created',
        'bap_created',
        'spmk_or_spp_created',
        'technical_checked',
    ];
}
