<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komitmen extends Model
{
    protected $fillable = [

        'periode',
        'level',
        'unit',

        'pemilik',
        'nip_pemilik',
        'jabatan_pemilik',

        'pengelola',
        'nip_pengelola',
        'jabatan_pengelola',

        'anggaran',
        'link',

        'status',
    ];
}