<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Komitmen;

class KomitmenController extends Controller
{
    // =========================
    // GET ALL
    // =========================
    public function index()
    {
        return response()->json(
            Komitmen::latest()->get()
        );
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([

            'periode' => 'required',
            'level' => 'required',
            'unit' => 'required',

            'pemilik' => 'nullable',
            'nip_pemilik' => 'nullable',
            'jabatan_pemilik' => 'nullable',

            'pengelola' => 'nullable',
            'nip_pengelola' => 'nullable',
            'jabatan_pengelola' => 'nullable',

            'anggaran' => 'nullable',
            'link' => 'nullable',

            'status' => 'required',
        ]);

        $komitmen = Komitmen::create($validated);

        return response()->json([
            'message' => 'Berhasil tambah',
            'data' => $komitmen
        ]);
    }

    // =========================
    // DETAIL
    // =========================
    public function show($id)
    {
        $komitmen = Komitmen::find($id);

        if (!$komitmen) {

            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json($komitmen);
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $komitmen = Komitmen::findOrFail($id);

        $komitmen->update($request->all());

        return response()->json([
            'message' => 'Berhasil update',
            'data' => $komitmen
        ]);
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $komitmen = Komitmen::findOrFail($id);

        $komitmen->delete();

        return response()->json([
            'message' => 'Berhasil hapus'
        ]);
    }
}