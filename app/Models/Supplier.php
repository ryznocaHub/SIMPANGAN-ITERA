<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'npwp',
        'entity',
        'address',
        'province',
        'regency',
        'bank',
        'account',
        'account',
    ];
}
