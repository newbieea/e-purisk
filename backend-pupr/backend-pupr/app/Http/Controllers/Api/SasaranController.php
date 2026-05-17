<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sasaran;

class SasaranController extends Controller
{
    // ==========================
    // GET SASARAN
    // ==========================
    public function show($komitmenId)
    {
        $data = Sasaran::where(
            'komitmen_id',
            $komitmenId
        )->first();

        return response()->json(
            $data?->data ?? []
        );
    }

    // ==========================
    // STORE / UPDATE
    // ==========================
    public function store(Request $request)
    {
        $cek = Sasaran::where(
            'komitmen_id',
            $request->komitmen_id
        )->first();

        // UPDATE
        if ($cek) {

            $cek->update([
                'data' => $request->data
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil update',
                'data' => $cek
            ]);
        }

        // CREATE
        $sasaran = Sasaran::create([

            'komitmen_id' =>
                $request->komitmen_id,

            'data' =>
                $request->data,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil',
            'data' => $sasaran
        ]);
    }

    // ==========================
    // DELETE
    // ==========================
    public function destroy($id)
    {
        $data = Sasaran::findOrFail($id);

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil dihapus'
        ]);
    }
}