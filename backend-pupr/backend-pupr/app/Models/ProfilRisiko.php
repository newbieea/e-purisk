<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilRisiko extends Model
{
    use HasFactory;

    protected $table = 'profil_risikos';

    protected $fillable = [

        'komitmen_id',
        'paket_id',

        'kode',

        'kategori',
        'kegiatan',
        'tujuan',
        'tahapan',

        'pernyataan',

        'dampak',
        'dampak_kategori',

        'penanggung_jawab',

        'k',
        'd',
        'skor',

        'prioritas',

        'respon',

        'rtp_k',
        'rtp_d',
        'rtp_n',

        'sumber',

        'klasifikasi'
    ];

    public function komitmen()
    {
        return $this->belongsTo(Komitmen::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function penyebab()
    {
        return $this->hasMany(PenyebabRisiko::class);
    }

    public function rtp()
    {
        return $this->hasMany(RTP::class);
    }

    public function unitTembusan()
    {
        return $this->hasMany(UnitTembusan::class);
    }
}