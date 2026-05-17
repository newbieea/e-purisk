<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Risiko;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun;

        // ================= PEGAWAI =================
        $pegawaiQuery = Pegawai::query();

        if ($tahun) {
            $pegawaiQuery->whereYear('created_at', $tahun);
        }

        $totalPegawai = $pegawaiQuery->count();

        $perJabatan = $pegawaiQuery
            ->selectRaw('jabatan, COUNT(*) as total')
            ->groupBy('jabatan')
            ->get();

        $perBulan = $pegawaiQuery
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // ================= RISIKO =================
        $risikoQuery = Risiko::query();

        if ($tahun) {
            $risikoQuery->whereYear('created_at', $tahun);
        }

        $totalRisiko = $risikoQuery->count();
        $rendah = $risikoQuery->where('risiko', 'Rendah')->count();
        $sedang = $risikoQuery->where('risiko', 'Sedang')->count();
        $tinggi = $risikoQuery->where('risiko', 'Tinggi')->count();

        // 🔥 CHART RISIKO PER SASARAN
        $risikoChart = Risiko::select(
            'sasaran',
            DB::raw("SUM(CASE WHEN risiko='Rendah' THEN 1 ELSE 0 END) as Rendah"),
            DB::raw("SUM(CASE WHEN risiko='Sedang' THEN 1 ELSE 0 END) as Sedang"),
            DB::raw("SUM(CASE WHEN risiko='Tinggi' THEN 1 ELSE 0 END) as Tinggi")
        )
        ->groupBy('sasaran')
        ->get();

        return response()->json([
            // KPI
            'kpi' => [
                'total_pegawai' => $totalPegawai,
                'total_risiko' => $totalRisiko,
                'rendah' => $rendah,
                'sedang' => $sedang,
                'tinggi' => $tinggi,
            ],

            // pegawai
            'pegawai' => [
                'per_jabatan' => $perJabatan,
                'per_bulan' => $perBulan,
            ],

            // risiko
            'risiko_chart' => $risikoChart,
        ]);
    }
}