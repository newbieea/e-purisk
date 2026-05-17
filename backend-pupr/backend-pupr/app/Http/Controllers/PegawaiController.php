<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Pegawai::query();

        // SEARCH
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nip', 'like', '%' . $request->search . '%')
                ->orWhere('jabatan', 'like', '%' . $request->search . '%');
        }

        // PAGINATION
        return response()->json(
            $query->latest()->paginate(5) // ubah 5 sesuai kebutuhan
        );
    }

    public function store(Request $request)
    {
        $data = Pegawai::create($request->all());
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($request->all());

        return response()->json($pegawai);
    }

    public function destroy($id)
    {
        Pegawai::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }

    public function show($id)
    {
        return response()->json(
            \App\Models\Pegawai::findOrFail($id)
        );
    }

    public function dashboard(Request $request)
    {
        $tahun = $request->tahun;

        $query = \App\Models\Pegawai::query();

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        // KPI
        $total = $query->count();

        // per jabatan (bar chart)
        $perJabatan = $query->selectRaw('jabatan, COUNT(*) as total')
            ->groupBy('jabatan')
            ->get();

        // pie chart (sama data, beda tampilan)
        $pie = $perJabatan;

        // line chart (per bulan)
        $perBulan = $query->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return response()->json([
            'total' => $total,
            'per_jabatan' => $perJabatan,
            'pie' => $pie,
            'per_bulan' => $perBulan
        ]);
    }

    
}
