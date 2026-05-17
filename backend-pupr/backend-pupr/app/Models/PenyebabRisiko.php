<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyebabRisiko extends Model
{
    use HasFactory;

    protected $fillable = [

        'profil_risiko_id',

        'kode',

        'jenis',

        'penyebab',

        'pengendalian',

        'status',
    ];
}