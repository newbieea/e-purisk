"use client";

import { useEffect, useState } from "react";
import Sidebar from "@/components/Sidebar";
import Navbar from "@/components/Navbar";
import { useRouter } from "next/navigation";

export default function ProfilRisikoPage() {
  const router = useRouter();

  const [profilRisiko, setProfilRisiko] = useState<any[]>([]);
  const [profilKorupsi, setProfilKorupsi] = useState<any[]>([]);
  const [open, setOpen] = useState(false);
  const [selectedKomitmenKorupsi, setSelectedKomitmenKorupsi] = useState<
    number | null
  >(null);
  const filteredKorupsi = selectedKomitmenKorupsi
    ? profilRisiko.filter((r) => r.komitmenId === selectedKomitmenKorupsi)
    : profilRisiko;
  const [form, setForm] = useState<any>({
    kode: "",
    tujuan: "",
    pernyataan: "",
    kategori: "",
    sebab: "",
    dampak: "",
    pengendalian: "",
    status: "",
    kemungkinan: "",
    dampakNilai: "",
    prioritas: "",
    respon: "",
    rtpJenis: "",
    rtpUraian: "",
    alokasi: "",
    kTarget: "",
    dTarget: "",
    penanggungJawab: "",
    waktu: "",
    output: "",
  });

  const handleSubmit = () => {
    const newData = [
      ...profilRisiko,
      {
        ...form,
        komitmenId: selectedKomitmen,
        // 🔥 INI WAJIB
      },
    ];
    setProfilRisiko(newData);
    localStorage.setItem("profil-risiko", JSON.stringify(newData));
    setOpen(false);

    setForm({
      kode: "",
      tujuan: "",
      pernyataan: "",
      kategori: "",
      sebab: "",
      dampak: "",
      pengendalian: "",
      status: "",
      kemungkinan: "",
      dampakNilai: "",
      prioritas: "",
      respon: "",
      rtpJenis: "",
      rtpUraian: "",
      alokasi: "",
      kTarget: "",
      dTarget: "",
      penanggungJawab: "",
      waktu: "",
      output: "",
    });
  };
  const [komitmenList, setKomitmenList] = useState<any[]>([]);
  const [selectedKomitmen, setSelectedKomitmen] = useState<number | null>(null);
  const [selectedData, setSelectedData] = useState<any>(null);
  const safeRtp = (rtp: any) => {
  try {
    if (Array.isArray(rtp)) return rtp;

    if (!rtp || rtp === "") return [];

    return JSON.parse(rtp);
  } catch {
    return [];
  }
};
  useEffect(() => {
    const data = JSON.parse(localStorage.getItem("komitmen") || "[]");
    setKomitmenList(data);
  }, []);
  const filteredRisiko = selectedKomitmen
    ? profilRisiko.filter((r) => r.komitmenId === selectedKomitmen)
    : profilRisiko;
  const filteredKorupsiOnly = profilRisiko.filter((r) => {
    const matchKomitmen = selectedKomitmen
      ? r.komitmenId === selectedKomitmen
      : true;

    const matchKategori = (r.kategori || "").toLowerCase() === "risiko korupsi";

    return matchKomitmen && matchKategori;
  });
  // LOAD DATA

  useEffect(() => {
    const data = JSON.parse(localStorage.getItem("profil-risiko") || "[]");
    setProfilRisiko(data);
    console.log("DATA PROFIL:", data);
  }, []);

  const handleSaveRisiko = () => {
    if (!selectedKomitmen) {
      alert("Pilih komitmen dulu!");
      return;
    }

    const existing = JSON.parse(localStorage.getItem("risiko") || "[]");

    const newRisiko = {
      id: Date.now(),
      komitmenId: selectedKomitmen, // 🔥 KUNCI
      jenis: "korupsi",
      uraian: form.uraian,
      dampak: form.dampak,
    };

    localStorage.setItem("risiko", JSON.stringify([...existing, newRisiko]));
  };
  useEffect(() => {
    if (!selectedKomitmen) return;

    const found = komitmenList.find((k) => k.id === selectedKomitmen);

    setSelectedData(found);
  }, [selectedKomitmen, komitmenList]);
  // AUTO MAP KE KORUPSI
  useEffect(() => {
    const mapped = profilRisiko.map((item, i) => ({
      no: i + 1,
      kode: item.kode || "-",
      tujuan: item.tujuan || "-",
      sub: item.sub || "-",
      pernyataan: item.pernyataan || "-",
      penyebab: item.sebab || "-",
      dampak: item.dampak || "-",
      internal: "Tenaga Pendukung",
      eksternal: "-",
      kategori: "Kerugian Negara",
    }));

    setProfilKorupsi(mapped);
  }, [profilRisiko]);

  return (
    <div className="flex min-h-screen bg-gray-100">
      <Sidebar />
      <div className="flex-1">
        <Navbar />
        <div className="p-6 space-y-6 max-w-full">
          {/* ================= PROFIL RISIKO ================= */}
          <div className="bg-white p-4 rounded-xl shadow mt-6">
            <h2 className="font-bold mb-3">1. Profil Risiko</h2>
            {selectedData && (
              <div className="grid grid-cols-2 gap-4 mb-4 text-sm bg-gray-50 p-3 rounded">
                <div>
                  <p>
                    <b>Nama Pemilik:</b> {selectedData.pemilik}
                  </p>
                  <p>
                    <b>Jabatan:</b> {selectedData.jabatan_pemilik}
                  </p>
                  <p>
                    <b>NIP:</b> {selectedData.nip_pemilik}
                  </p>
                </div>

                <div>
                  <p>
                    <b>Nama Pengelola:</b> {selectedData.pengelola}
                  </p>
                  <p>
                    <b>Jabatan:</b> {selectedData.jabatan_pengelola}
                  </p>
                  <p>
                    <b>NIP:</b> {selectedData.nip_pengelola}
                  </p>
                </div>
              </div>
            )}
            <div className="flex gap-2 mb-3">
              {/* 🔥 FILTER KOMITMEN */}
              <select
                value={selectedKomitmen || ""}
                onChange={(e) =>
                  setSelectedKomitmen(
                    e.target.value ? Number(e.target.value) : null,
                  )
                }
                className="border p-2 rounded"
              >
                <option value="">Semua Komitmen</option>
                {komitmenList.map((k) => (
                  <option key={k.id} value={k.id}>
                    {k.periode} - {k.unit}
                  </option>
                ))}
              </select>

              {/* 🔥 BUTTON KE DASH TAMBAH */}
              <button
                onClick={() => {
                  if (!selectedKomitmen) {
                    alert("Pilih komitmen dulu!");
                    return;
                  }

                  router.push(
                    `/risiko/korupsi/tambah?komitmenId=${selectedKomitmen}`,
                  );
                }}
                className="bg-purple-600 text-white px-3 py-1 rounded text-sm"
              >
                + Tambah
              </button>

              <button className="bg-green-600 text-white px-3 py-1 rounded text-sm">
                Export Excel Profil Risiko
              </button>
            </div>

            <div className="w-full overflow-hidden rounded-xl border">
              <div className="overflow-x-auto">
                <table className="min-w-[1800px] text-xs border border-gray-300">
                  <thead className="bg-purple-800 text-white text-[11px]">
                    <tr>
                      <th rowSpan={2} className="border p-2">
                        No
                      </th>
                      <th rowSpan={2} className="border p-2">
                        Kode Risiko
                      </th>
                      <th rowSpan={2} className="border p-2">
                        Tujuan
                      </th>
                      <th rowSpan={2} className="border p-2">
                        Pernyataan Risiko
                      </th>
                      <th rowSpan={2} className="border p-2">
                        Kategori
                      </th>
                      <th rowSpan={2} className="border p-2">
                        Penyebab
                      </th>
                      <th rowSpan={2} className="border p-2">
                        Dampak
                      </th>

                      <th colSpan={2} className="border p-2">
                        Pengendalian
                      </th>
                      <th colSpan={3} className="border p-2">
                        Nilai Risiko
                      </th>

                      <th rowSpan={2} className="border p-2">
                        Prioritas
                      </th>
                      <th rowSpan={2} className="border p-2">
                        Respon
                      </th>

                      <th colSpan={2} className="border p-2">
                        RTP
                      </th>

                      <th rowSpan={2} className="border p-2">
                        Alokasi
                      </th>

                      <th colSpan={3} className="border p-2">
                        Nilai Target
                      </th>

                      <th rowSpan={2} className="border p-2">
                        Penanggung Jawab
                      </th>

                      <th rowSpan={2} className="border p-2">
                        Target Waktu
                      </th>

                      <th rowSpan={2} className="border p-2">
                        Indikator
                      </th>
                    </tr>

                    <tr>
                      <th className="border">Uraian</th>
                      <th className="border">Status</th>

                      <th className="border">K</th>
                      <th className="border">D</th>
                      <th className="border">Nilai</th>

                      <th className="border">Jenis</th>
                      <th className="border">Uraian</th>

                      <th className="border">K</th>
                      <th className="border">D</th>
                      <th className="border">Nilai</th>
                    </tr>
                  </thead>

                  <tbody>
                    {filteredRisiko.length === 0 ? (
                      <tr>
                        <td
                          colSpan={23}
                          className="text-center p-4 text-gray-400"
                        >
                          Belum ada data
                        </td>
                      </tr>
                    ) : (
                      filteredRisiko.map((r, i) => {
                        const nilai = (Number(r.k) || 0) * (Number(r.d) || 0);
                        const nilaiTarget =
                          (Number(r.rtp_k) || 0) * (Number(r.rtp_d) || 0);

                        return (
                          <tr key={i}>
                            <td className="border p-2">{i + 1}</td>
                            <td className="border p-2">{r.kode}</td>
                            <td className="border p-2">{r.tujuan}</td>
                            <td className="border p-2">{r.pernyataan}</td>

                            <td className="border p-2">
                              <span
                                className={`px-2 py-1 rounded text-xs text-white
      ${r.kategori === "Risiko Korupsi" ? "bg-red-500" : ""}
      ${r.kategori === "Risiko Keuangan" ? "bg-green-500" : ""}
      ${r.kategori === "Risiko Hukum" ? "bg-blue-500" : ""}
      ${r.kategori === "Risiko kinerja" ? "bg-yellow-500 text-black" : ""}
      ${r.kategori === "Risiko layanan" ? "bg-gray-500" : ""}
      ${r.kategori === "Risiko reputasi" ? "bg-purple-500" : ""}
      ${r.kategori === "Risiko kecelakaan kerja" ? "bg-orange-500" : ""}
      ${r.kategori === "Risiko spbe" ? "bg-indigo-500" : ""}
    `}
                              >
                                {r.kategori}
                              </span>
                            </td>

                            <td className="border p-2">
                              {Array.isArray(r.penyebab)
                                ? r.penyebab
                                    .map((p: any) =>
                                      typeof p === "object"
                                        ? p.penyebab || "-"
                                        : String(p),
                                    )
                                    .join(", ")
                                : typeof r.penyebab === "object"
                                  ? r.penyebab?.penyebab || "-"
                                  : r.penyebab || "-"}
                            </td>

                            <td className="border p-2">
                              <div className="text-blue-600 font-semibold">
                                {r.dampakKategori}
                              </div>
                              <div className="text-xs">{r.dampak}</div>
                            </td>

                            <td className="border p-2">
                              {Array.isArray(r.penyebab)
                                ? r.penyebab
                                    .map((p: any) =>
                                      typeof p === "object"
                                        ? p.pengendalian || "-"
                                        : "-",
                                    )
                                    .join(", ")
                                : "-"}
                            </td>
                            <td className="border p-2">
                              {Array.isArray(r.penyebab)
                                ? r.penyebab
                                    .map((p: any) =>
                                      typeof p === "object"
                                        ? p.status || "-"
                                        : "-",
                                    )
                                    .join(", ")
                                : "-"}
                            </td>

                            <td className="border p-2">{r.k}</td>
                            <td className="border p-2">{r.d}</td>
                            <td className="border p-2 bg-yellow-300 font-bold">
                              {nilai}
                            </td>

                            <td className="border p-2">{r.prioritas}</td>
                            <td className="border p-2">{r.respon}</td>

                            <td className="border p-2">
                              {(Array.isArray(r.rtp)
                                ? r.rtp
                                : JSON.parse(r.rtp || "[]")
                              )
                                .map((x: any) => x.jenis_rtp || x.jenisRtp)
                                .join(", ") || "-"}
                            </td>

                            <td className="border p-2">
                              {(Array.isArray(r.rtp)
                                ? r.rtp
                                : JSON.parse(r.rtp || "[]")
                              )
                                .map((x: any) => x.uraian)
                                .join(", ")}
                            </td>

                            <td className="border p-2">{r.sumber}</td>

                            <td className="border p-2">{r.rtp_k}</td>
                            <td className="border p-2">{r.rtp_d}</td>
                            <td className="border p-2 bg-green-500 text-white font-bold">
                              {nilaiTarget}
                            </td>

                            <td className="border p-2">
                              {(Array.isArray(r.rtp)
                                ? r.rtp
                                : JSON.parse(r.rtp || "[]")
                              )
                                .map((x: any) => x.penanggung_jawab)
                                .join(", ") ||
                                r.penanggungJawab ||
                                "-"}
                            </td>

                            <td className="border p-2">
                              {safeRtp(r.rtp)
  .flatMap((x: any) => x.targetList || [])
  .map((t: any) => t.waktu)
  .join(", ") || "-"}
                            </td>

                            <td className="border p-2">
                              {safeRtp(r.rtp)
  .map((x: any) => x.indikator)
  .join(", ") || "-"}
                            </td>
                          </tr>
                        );
                      })
                    )}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          {/* ================= PROFIL RISIKO KORUPSI ================= */}
          <div className="bg-white p-4 rounded-xl shadow">
            <h2 className="font-bold mb-3">2. Profil Risiko Korupsi</h2>
            <div className="flex gap-2 mb-3">
              <select
                value={selectedKomitmen || ""}
                onChange={(e) =>
                  setSelectedKomitmen(
                    e.target.value ? Number(e.target.value) : null,
                  )
                }
                className="border p-2 rounded"
              >
                <option value="">Semua Komitmen</option>
                {komitmenList.map((k) => (
                  <option key={k.id} value={k.id}>
                    {k.periode} - {k.unit}
                  </option>
                ))}
              </select>
            </div>
            <div className="w-full overflow-hidden rounded-xl border">
              <div className="overflow-x-auto">
                <table className="min-w-[2000px] text-xs border border-gray-300">
                  <thead className="bg-purple-900 text-white text-[11px]">
                    {/* BARIS 1 */}
                    <tr>
                      <th rowSpan={3} className="border p-2">
                        No
                      </th>
                      <th rowSpan={3} className="border p-2">
                        Kode Risiko
                      </th>
                      <th rowSpan={3} className="border p-2">
                        Sub Proses Bisnis
                      </th>

                      <th colSpan={2} className="border p-2">
                        Pihak Terlibat
                      </th>

                      <th rowSpan={3} className="border p-2">
                        Pernyataan Risiko
                      </th>
                      <th rowSpan={3} className="border p-2">
                        Sub Kategori
                      </th>
                      <th rowSpan={3} className="border p-2">
                        Alat Bukti
                      </th>

                      <th colSpan={2} className="border p-2">
                        Penyebab Korupsi
                      </th>

                      <th rowSpan={3} className="border p-2">
                        Pengendalian yang sudah berjalan
                      </th>

                      <th colSpan={3} className="border p-2">
                        Nilai Risiko
                      </th>

                      <th colSpan={2} className="border p-2">
                        Rencana Tindak Pengendalian (RTP)
                      </th>

                      <th colSpan={3} className="border p-2">
                        Nilai Target
                      </th>

                      <th rowSpan={3} className="border p-2">
                        Indikator
                      </th>

                      <th colSpan={2} className="border p-2">
                        Waktu
                      </th>

                      <th rowSpan={3} className="border p-2">
                        Penanggung Jawab
                      </th>
                    </tr>

                    {/* BARIS 2 */}
                    <tr>
                      <th className="border p-1">Internal</th>
                      <th className="border p-1">Eksternal</th>

                      <th className="border p-1">Jenis</th>
                      <th className="border p-1">Uraian</th>

                      <th className="border p-1">K</th>
                      <th className="border p-1">D</th>
                      <th className="border p-1">Nilai</th>

                      <th className="border p-1">Jenis</th>
                      <th className="border p-1">Uraian</th>

                      <th className="border p-1">K</th>
                      <th className="border p-1">D</th>
                      <th className="border p-1">Nilai</th>

                      <th className="border p-1">Rencana</th>
                      <th className="border p-1">Realisasi</th>
                    </tr>
                  </thead>
                  <tbody>
                    {filteredKorupsiOnly.length === 0 ? (
                      <tr>
                        <td
                          colSpan={23}
                          className="text-center p-4 text-gray-400"
                        >
                          Belum ada data
                        </td>
                      </tr>
                    ) : (
                      filteredKorupsiOnly.map((r, i) => {
                        const nilai = (Number(r.k) || 0) * (Number(r.d) || 0);
                        const nilaiTarget =
                          (Number(r.rtp_k) || 0) * (Number(r.rtp_d) || 0);

                      
                        const safeValue = (value: any) => {
                          if (value === null || value === undefined) {
                            return "-";
                          }

                          if (
                            typeof value === "string" ||
                            typeof value === "number"
                          ) {
                            return value;
                          }

                          if (Array.isArray(value)) {
                            return value
                              .map((v) => {
                                if (typeof v === "object") {
                                  return (
                                    v.penyebab ||
                                    v.pengendalian ||
                                    v.status ||
                                    v.indikator ||
                                    v.uraian ||
                                    JSON.stringify(v)
                                  );
                                }

                                return String(v);
                              })
                              .join(", ");
                          }

                          if (typeof value === "object") {
                            return (
                              value.penyebab ||
                              value.pengendalian ||
                              value.status ||
                              value.indikator ||
                              value.uraian ||
                              JSON.stringify(value)
                            );
                          }

                          return String(value);
                        };

                        return (
                          <tr key={i}>
                            {/* NO */}
                            <td className="border p-2">{i + 1}</td>

                            {/* KODE */}
                            <td className="border p-2">{r.kode || "-"}</td>

                            {/* SUB PROSES */}
                            <td className="border p-2">{r.subProses || "-"}</td>

                            {/* INTERNAL */}
                            <td className="border p-2">
                              {r.pihakList?.length
                                ? r.pihakList
                                    .filter((p: any) => p.jenis === "INTERNAL")
                                    .map((p: any) => p.nama)
                                    .join(", ")
                                : "-"}
                            </td>

                            {/* EKSTERNAL */}
                            <td className="border p-2">
                              {r.pihakList?.length
                                ? r.pihakList
                                    .filter((p: any) => p.jenis === "EKSTERNAL")
                                    .map((p: any) => p.nama)
                                    .join(", ")
                                : "-"}
                            </td>

                            {/* PERNYATAAN */}
                            <td className="border p-2">
                              {r.pernyataan || "-"}
                            </td>

                            {/* SUB KATEGORI */}
                            <td className="border p-2">
                              {r.subKategori || "-"}
                            </td>

                            {/* ALAT BUKTI */}
                            <td className="border p-2">{r.alatBukti || "-"}</td>

                            {/* PENYEBAB JENIS */}
                            <td className="border p-2">
                              {r.penyebabList
                                ?.map((p: any) => p.jenis)
                                .join(", ") || "-"}
                            </td>

                            {/* PENYEBAB URAIAN */}
                            <td className="border p-2">
                              {r.penyebabList
                                ?.map((p: any) => p.penyebab)
                                .join(", ") || "-"}
                            </td>

                            {/* PENGENDALIAN */}
                            <td className="border p-2">
                              {r.penyebabList
                                ?.map((p: any) => p.pengendalian)
                                .join(", ") || "-"}
                            </td>

                            {/* NILAI */}
                            <td className="border p-2">{r.k || "-"}</td>
                            <td className="border p-2">{r.d || "-"}</td>

                            <td className="border p-2 bg-yellow-300 font-bold text-center">
                              {nilai}
                            </td>

                            {/* RTP */}
                            <td className="border p-2">
                              {safeRtp(r.rtp)?.map((x: any) => x.jenis_rtp).join(", ") ||
                                "-"}
                            </td>

                            <td className="border p-2">
                              {safeRtp(r.rtp)?.map((x: any) => x.uraian).join(", ") ||
                                "-"}
                            </td>

                            {/* TARGET */}
                            <td className="border p-2">{r.rtp_k || "-"}</td>
                            <td className="border p-2">{r.rtp_d || "-"}</td>

                            <td className="border p-2 bg-green-500 text-white font-bold text-center">
                              {nilaiTarget}
                            </td>

                            {/* INDIKATOR */}
                            <td className="border p-2">
                              {safeRtp(r.rtp)
  .map((x: any) => x.indikator)
  .join(", ") || "-"}
                            </td>

                            {/* WAKTU */}
                            <td className="border p-2">
                              {safeRtp(r.rtp)
  .flatMap((x: any) => x.targetList || [])
  .map((t: any) => t.waktu)
  .join(", ") || "-"}
                            </td>

                            {/* REALISASI */}
                            <td className="border p-2">
                             {safeRtp(r.rtp)
  .flatMap((x: any) => x.targetList || [])
  .map((t: any) => t.realisasi || "-")
  .join(", ") || "-"}
                            </td>

                            {/* PIC */}
                            <td className="border p-2">
                              {safeRtp(r.rtp).length
  ? safeRtp(r.rtp)
      .map((x: any) => x.penanggungJawab)
      .join(", ")
  : r.penanggungJawab || "-"}
                            </td>
                          </tr>
                        );
                      })
                    )}
                  </tbody>
                </table>
              </div>{" "}
              {/* overflow-x-auto */}
            </div>{" "}
            {/* border wrapper */}
          </div>{" "}
          {/* card */}
        </div>{" "}
        {/* p-6 */}
      </div>{" "}
      {/* flex-1 */}
    </div>
  );
}
