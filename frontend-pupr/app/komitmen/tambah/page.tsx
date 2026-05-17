"use client";

import Sidebar from "@/components/Sidebar";
import Navbar from "@/components/Navbar";
import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import axios from "axios";

export default function TambahKomitmenPage() {

  const router = useRouter();

  const [form, setForm] = useState<any>({});

  const [pegawai, setPegawai] = useState<any[]>([]);

  const [loading, setLoading] = useState(false);

  // ======================================
  // FETCH PEGAWAI DARI BACKEND
  // ======================================
  const fetchPegawai = async () => {

    try {

      const res = await axios.get(
        "http://127.0.0.1:8000/api/pegawai"
      );

      console.log("PEGAWAI:", res.data);

      if (Array.isArray(res.data)) {

        setPegawai(res.data);

      } else if (Array.isArray(res.data.data)) {

        setPegawai(res.data.data);

      } else {

        setPegawai([]);
      }

    } catch (error) {

      console.error(error);

      alert("Gagal mengambil data pegawai");
    }
  };

  // ======================================
  // LOAD
  // ======================================
  useEffect(() => {

    fetchPegawai();

  }, []);

  // ======================================
  // HANDLE SELECT
  // ======================================
  const handleSelect = (
    type: "pemilik" | "pengelola",
    nama: string
  ) => {

    const selected = pegawai.find(
      (p: any) => p.nama === nama
    );

    if (!selected) return;

    // PEMILIK
    if (type === "pemilik") {

      setForm((prev: any) => ({

        ...prev,

        pemilik: selected.nama,

        nip_pemilik: selected.nip,

        jabatan_pemilik:
          selected.jabatan,
      }));
    }

    // PENGELOLA
    if (type === "pengelola") {

      setForm((prev: any) => ({

        ...prev,

        pengelola: selected.nama,

        nip_pengelola:
          selected.nip,

        jabatan_pengelola:
          selected.jabatan,
      }));
    }
  };

  // ======================================
  // HANDLE INPUT
  // ======================================
  const handleChange = (e: any) => {

    const { name, value } = e.target;

    setForm((prev: any) => ({

      ...prev,

      [name]: value,
    }));
  };

  // ======================================
  // SIMPAN KE BACKEND
  // ======================================
  const handleSubmit = async () => {

    setLoading(true);

    try {

      const payload = {

        periode:
          form.tahun || "2026",

        level:
          "UPR T3",

        unit:
          "BALAI WILAYAH SUNGAI BENGAWAN SOLO",

        // 🔥 FIX DEFAULT VALUE
        pemilik:
          form.pemilik || "-",

        nip_pemilik:
          form.nip_pemilik || "-",

        jabatan_pemilik:
          form.jabatan_pemilik || "-",

        // 🔥 FIX DEFAULT VALUE
        pengelola:
          form.pengelola || "-",

        nip_pengelola:
          form.nip_pengelola || "-",

        jabatan_pengelola:
          form.jabatan_pengelola || "-",

        anggaran:
          form.anggaran || "0",

        link:
          form.link || "-",

        status:
          "Draft",
      };

      console.log("PAYLOAD:", payload);

      const res = await axios.post(
        "http://127.0.0.1:8000/api/komitmen",
        payload
      );

      console.log("RESPONSE:", res.data);

      alert("✅ Komitmen berhasil disimpan");

      // FIX ID RESPONSE
      const newId =
        res.data?.id ||
        res.data?.data?.id;

      router.push(`/komitmen/${newId}`);

    } catch (error: any) {

      console.error(error);

      console.log(error.response);

      alert(
        JSON.stringify(
          error.response?.data,
          null,
          2
        )
      );

    } finally {

      setLoading(false);
    }
  };

  return (
    <div className="flex min-h-screen bg-gray-100">

      <Sidebar />

      <div className="flex-1">

        <Navbar />

        <div className="p-6">

          <h1 className="text-lg font-semibold mb-4">
            Tambah Komitmen MR
          </h1>

          <div className="bg-white rounded-xl shadow p-6">

            <div className="space-y-4">

              {/* TAHUN */}
              <div>

                <label className="text-sm text-gray-800 font-medium">
                  Tahun
                </label>

                <select
                  name="tahun"
                  onChange={handleChange}
                  className="w-full border rounded p-2 mt-1 text-black bg-white"
                >

                  <option>
                    Pilih Tahun
                  </option>

                  {[2023, 2024, 2025, 2026].map((t) => (

                    <option key={t}>
                      {t}
                    </option>
                  ))}

                </select>

              </div>

              {/* PEMILIK */}
              <div>

                <label className="text-sm text-gray-800 font-medium">
                  Pemilik Risiko
                </label>

                <select
                  onChange={(e) =>
                    handleSelect(
                      "pemilik",
                      e.target.value
                    )
                  }
                  className="w-full border rounded p-2 mt-1"
                >

                  <option>
                    Pilih Pemilik Risiko
                  </option>

                  {pegawai.map((p) => (

                    <option
                      key={p.id}
                    >
                      {p.nama}
                    </option>
                  ))}

                </select>

              </div>

              {/* JABATAN PEMILIK */}
              <input
                value={
                  form.jabatan_pemilik || ""
                }
                readOnly
                className="w-full border p-2 bg-white text-black rounded"
              />

              {/* PENGELOLA */}
              <div>

                <label className="text-sm text-gray-800 font-medium">
                  Pengelola Risiko
                </label>

                <select
                  onChange={(e) =>
                    handleSelect(
                      "pengelola",
                      e.target.value
                    )
                  }
                  className="w-full border rounded p-2 mt-1"
                >

                  <option>
                    Pilih Pengelola
                  </option>

                  {pegawai.map((p) => (

                    <option
                      key={p.id}
                    >
                      {p.nama}
                    </option>
                  ))}

                </select>

              </div>

              {/* JABATAN PENGELOLA */}
              <input
                value={
                  form.jabatan_pengelola || ""
                }
                readOnly
                className="w-full border p-2 bg-white text-black rounded"
              />

              {/* ANGGARAN */}
              <input
                name="anggaran"
                onChange={handleChange}
                placeholder="Anggaran"
                className="w-full border p-2 rounded text-black bg-white"
              />

              {/* LINK */}
              <input
                name="link"
                onChange={handleChange}
                placeholder="Link"
                className="w-full border p-2 rounded text-black bg-white"
              />

              {/* BUTTON */}
              <button
                onClick={handleSubmit}
                disabled={loading}
                className="bg-green-600 text-white px-4 py-2 rounded"
              >

                {loading
                  ? "Loading..."
                  : "Simpan"}

              </button>

            </div>

          </div>

        </div>

      </div>

    </div>
  );
}