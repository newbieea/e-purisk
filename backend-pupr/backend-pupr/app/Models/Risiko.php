<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Risiko extends Model
{
   protected $fillable = [
    'kode',
    'tujuan',
    'pernyataan',
    'kategori',
    'penyebab',
    'dampak',
    'pengendalian',
    'hasil',
    'k',
    'd',
    'prioritas',
    'respon',
    'tahun',
    'komitmenId',
    'rtp_k',
    'rtp_d'
];
}