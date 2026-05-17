<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfilRisiko;
use App\Models\PenyebabRisiko;
use App\Models\RTP;
use App\Models\TargetRTP;
use App\Models\UnitTembusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfilRisikoController extends Controller
{
    public function index(Request $request)
    {
        $query = ProfilRisiko::with([
            'komitmen',
            'paket',
            'penyebab',
            'rtp.target',
            'unitTembusan'
        ]);

        if ($request->komitmen_id) {
            $query->where('komitmen_id', $request->komitmen_id);
        }

        return response()->json(
            $query->latest()->get()
        );
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $profil = ProfilRisiko::create([
                'komitmen_id' => $request->komitmen_id,
                'paket_id' => $request->paket_id,
                'kode' => $request->kode,
                'kategori' => $request->kategori,
                'kegiatan' => $request->kegiatan,
                'tujuan' => $request->tujuan,
                'tahapan' => $request->tahapan,
                'pernyataan' => $request->pernyataan,
                'dampak' => $request->dampak,
                'dampak_kategori' => $request->dampak_kategori,
                'penanggung_jawab' => $request->penanggung_jawab,
                'k' => $request->k,
                'd' => $request->d,
                'skor' => $request->skor,
                'prioritas' => $request->prioritas,
                'respon' => $request->respon,
                'rtp_k' => $request->rtp_k,
                'rtp_d' => $request->rtp_d,
                'rtp_n' => $request->rtp_n,
                'sumber' => $request->sumber,
                'klasifikasi' => $request->klasifikasi,
            ]);

            if ($request->penyebab) {
                $penyebab = json_decode($request->penyebab, true);
                foreach ($penyebab as $item) {

                    PenyebabRisiko::create([
                        'profil_risiko_id' => $profil->id,
                        'kode' => $item['kode'],
                        'jenis' => $item['jenis'],
                        'penyebab' => $item['penyebab'],
                        'pengendalian' => $item['pengendalian'],
                        'status' => $item['status'],
                    ]);
                }
            }

            if ($request->rtp) {
                $rtpList = json_decode($request->rtp, true);
                foreach ($rtpList as $item) {

                    $rtp = RTP::create([
                        'profil_risiko_id' => $profil->id,
                        'jenis_rtp' => $item['jenis_rtp'],
                        'uraian' => $item['uraian'],
                        'indikator' => $item['indikator'],
                        'berbagi' => $item['berbagi'],
                        'periode' => $item['periode'],
                        'respon' => $item['respon'],
                        'penanggung_jawab' => $item['penanggung_jawab'],
                    ]);

                    if (isset($item['target'])) {

                        foreach ($item['target'] as $target) {

                            TargetRTP::create([
                                'rtp_id' => $rtp->id,
                                'waktu' => $target['waktu'],
                                'uraian' => $target['uraian'],
                            ]);
                        }
                    }
                }
            }

            if ($request->unit_tembusan) {
                $unitTembusan = json_decode($request->unit_tembusan, true);

                foreach ($unitTembusan as $unit) {

                    UnitTembusan::create([
                        'profil_risiko_id' => $profil->id,
                        'nama' => $unit,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profil Risiko berhasil disimpan',
                'data' => $profil
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return ProfilRisiko::with([
            'komitmen',
            'paket',
            'penyebab',
            'rtp.target',
            'unitTembusan'
        ])->findOrFail($id);
    }

    public function destroy($id)
    {
        $data = ProfilRisiko::findOrFail($id);

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}