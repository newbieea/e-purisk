<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sasaran extends Model
{
    protected $table = 'sasarans';

    protected $fillable = [
        'komitmen_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}