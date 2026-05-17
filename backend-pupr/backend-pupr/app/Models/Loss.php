<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loss extends Model
{
    protected $fillable = [
        'sumber',
        'tanggalCatat',
        'uraian',
        'waktu',
        'lokasi',
        'sebab',
        'kondisi',
        'dampak',
        'rincian',
        'unit'
    ];
}