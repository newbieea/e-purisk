<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Realisasi;

class RealisasiController extends Controller
{
    public function store(Request $request)
    {
        $data = Realisasi::create($request->all());
        return response()->json($data);
    }
}