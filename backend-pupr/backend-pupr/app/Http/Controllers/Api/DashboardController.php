<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Pegawai;
use App\Models\Komitmen;
use App\Models\Risiko;
use App\Models\ProfilRisiko;
use App\Models\PenyebabRisiko;
use App\Models\RTP;
use App\Models\TargetRTP;
use App\Models\Loss;
use App\Models\Realisasi;
use App\Models\Kegiatan;
use App\Models\Sasaran;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        // ================= KPI =================
        $totalPegawai = Pegawai::count();

        $totalKomitmen = Komitmen::count();

        $totalRisiko = Risiko::count();

        $totalProfilRisiko = ProfilRisiko::count();

        $totalLoss = Loss::count();

        $totalRealisasi = Realisasi::count();

        $totalKegiatan = Kegiatan::count();

        $totalSasaran = Sasaran::count();

        // ================= LEVEL RISIKO =================
        $tinggi = Risiko::whereRaw('k * d >= 15')->count();

        $sedang = Risiko::whereRaw('k * d BETWEEN 5 AND 14')->count();

        $rendah = Risiko::whereRaw('k * d < 5')->count();

        // ================= PEGAWAI =================
        $pegawaiPerJabatan = Pegawai::select(
                'jabatan',
                DB::raw('count(*) as total')
            )
            ->groupBy('jabatan')
            ->get();

        // ================= RISIKO PER KATEGORI =================
        $kategoriRisiko = Risiko::select(
                'kategori',
                DB::raw('count(*) as total')
            )
            ->groupBy('kategori')
            ->get();

        // ================= PRIORITAS =================
        $prioritasRisiko = Risiko::select(
                'prioritas',
                DB::raw('count(*) as total')
            )
            ->groupBy('prioritas')
            ->get();

        // ================= RISIKO PER TAHUN =================
        $risikoPerTahun = Risiko::select(
                'tahun',
                DB::raw('count(*) as total')
            )
            ->groupBy('tahun')
            ->get();

        // ================= KOMITMEN PER UNIT =================
        $komitmenPerUnit = Komitmen::select(
                'unit',
                DB::raw('count(*) as total')
            )
            ->groupBy('unit')
            ->get();

        // ================= LOSS =================
        $lossPerTahun = Loss::select(
                'tahun',
                DB::raw('count(*) as total')
            )
            ->groupBy('tahun')
            ->get();

        return response()->json([

            // KPI
            'kpi' => [

                'total_pegawai' => $totalPegawai,

                'total_komitmen' => $totalKomitmen,

                'total_risiko' => $totalRisiko,

                'total_profil_risiko' => $totalProfilRisiko,

                'total_loss' => $totalLoss,

                'total_realisasi' => $totalRealisasi,

                'total_kegiatan' => $totalKegiatan,

                'total_sasaran' => $totalSasaran,

                'rendah' => $rendah,

                'sedang' => $sedang,

                'tinggi' => $tinggi,
            ],

            // Pegawai
            'pegawai' => [
                'per_jabatan' => $pegawaiPerJabatan,
            ],

            // Risiko
            'kategori_risiko' => $kategoriRisiko,

            'prioritas_risiko' => $prioritasRisiko,

            'risiko_per_tahun' => $risikoPerTahun,

            // Komitmen
            'komitmen_per_unit' => $komitmenPerUnit,

            // Loss
            'loss_per_tahun' => $lossPerTahun,
        ]);
    }
}