<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RTP extends Model
{
    protected $table = 'r_t_p_s';

    protected $fillable = [
        'profil_risiko_id',
        'penyebab_risiko_id',
        'jenis_rtp',
        'uraian',
        'indikator',
        'berbagi',
        'periode',
        'respon',
        'penanggung_jawab'
    ];

    public function target()
    {
        return $this->hasMany(TargetRTP::class, 'rtp_id');
    }
}
