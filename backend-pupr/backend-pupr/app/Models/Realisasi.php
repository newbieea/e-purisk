<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kegiatan;

class Realisasi extends Model
{
    protected $table = 'realisasi';

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
}