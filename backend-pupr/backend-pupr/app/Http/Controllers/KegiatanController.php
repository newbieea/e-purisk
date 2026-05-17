<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;

class KegiatanController extends Controller
{
    public function index()
    {
        return response()->json(Kegiatan::with('sasaran')->get());
    }

    public function store(Request $request)
    {
        $data = Kegiatan::create($request->all());
        return response()->json($data);
    }
}