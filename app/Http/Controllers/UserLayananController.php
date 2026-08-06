<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Layanan;
use App\Models\Kategori;

class UserLayananController extends Controller
{
    // =========================
    // Halaman form user
    // =========================
    public function index()
    {
        $userRole = auth()->user()->role;

        // Role "user" (jabatan bawah koordinator) bisa lihat semua kategori aktif
        // Role unit spesifik hanya lihat kategori miliknya
        $isGenericUser = ($userRole === 'user');

        $kategoris = \App\Models\Kategori::where('is_active', true)
            ->when(!$isGenericUser, function ($q) use ($userRole) {
                $q->where(function ($q2) use ($userRole) {
                    $q2->whereJsonContains('roles', $userRole)
                       ->orWhere('role', $userRole);
                });
            })
            ->with(['layanans' => function ($q) {
                $q->where('is_active', true)->with('biodataFields');
            }])
            ->get();

        $layanans = $kategoris->flatMap->layanans;

        $doctors = \App\Models\Employee::where('posisi_pekerjaan', 'like', 'DOKTER%')
            ->orderBy('nama_karyawan')
            ->get();

        $karyawans = \App\Models\Employee::orderBy('nama_karyawan')->get();

        // Map layanan_id => array of field configs untuk JS
        $biodataMap = $layanans->mapWithKeys(function ($l) {
            return [$l->nama_layanan => $l->biodataFields->map(fn($f) => [
                'label'     => $f->label,
                'field_key' => $f->field_key,
                'suffix'    => $f->suffix,
            ])->values()];
        });

        // Map konfigurasi tampilan field per layanan
        $layananConfigMap = $layanans->mapWithKeys(function ($l) {
            return [$l->nama_layanan => [
                'show_nama_dokter'    => (bool) $l->show_nama_dokter,
                'show_dokter_section' => (bool) $l->show_dokter_section,
                'show_nama_suami'     => (bool) $l->show_nama_suami,
                'show_bangsa'         => (bool) $l->show_bangsa,
            ]];
        });

        return view('layanan.create', compact('kategoris', 'layanans', 'biodataMap', 'layananConfigMap', 'doctors', 'karyawans'));
    }

    // =========================
    // Simpan permintaan user
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'layanan'     => 'required',
            'keterangan'  => 'required_if:layanan,lain-lain|nullable|string',
        ]);

        $namaLayanan = $request->layanan;
        if ($namaLayanan === 'lain-lain' && !empty($request->keterangan)) {
            $lines       = explode("\n", $request->keterangan, 2);
            $namaLayanan = trim($lines[0]);
        }

        // Simpan ke tabel layanans jika belum ada
        // Jika berasal dari "lain-lain", masukkan ke kategori rekam medis
        $kategoriRekamMedis = \App\Models\Kategori::where('role', 'rekam_medis')->first();
        $defaultKategoriId  = $request->layanan === 'lain-lain' && $kategoriRekamMedis
            ? $kategoriRekamMedis->id
            : null;

        Layanan::firstOrCreate(
            ['nama_layanan' => $namaLayanan],
            ['deskripsi' => null, 'is_active' => true, 'kategori_id' => $defaultKategoriId]
        );

        // Kolom yang boleh diisi user dari biodata fields
        $allowedFields = [
            'nama', 'nama_suami', 'umur', 'kode_rm', 'alamat', 'no_telepon', 'bangsa', 'nm_penerima',
            'tempat_lahir', 'tgl_lahir', 'jenis_kelamin',
            'no_hp', 'nm_petugas_rm', 'nama_peminta', 'email_peminta',
            'no_whatsapp', 'up', 'jumlah_form_asuransi', 'tgl_rencana_kirim',
            'nama_dokter',
            'diagnosis', 'poliklinik',
            'keterangan_lain_lain',
            'tgl_masuk', 'tgl_keluar', 'tgl_periksa', 'tgl_berobat',
            'usia_kehamilan_minggu', 'usia_kehamilan_hari',
            'no_surat_kelahiran', 'jenis_kelamin_bayi', 'tgl_lahir_bayi', 'jam_lahir_bayi',
        ];

        $fillData = [
            'no_permintaan'      => 'REQ-' . time(),
            'layanan'            => $namaLayanan,
            'tanggal'            => now(),
            'isi_surat'          => null,
            'nm_petugas_rm'      => null,
            'status'             => 'pending',
            'role'               => 'user',
            'user_id'            => auth()->id(),
            'is_lain_lain'       => $request->layanan === 'lain-lain' ? true : false,
            'keterangan_lain_lain' => null,
        ];

        // Untuk lain-lain: pisah baris pertama (nama) dan sisanya (deskripsi)
        if ($request->layanan === 'lain-lain' && !empty($request->keterangan)) {
            $lines = explode("\n", $request->keterangan, 2);
            $fillData['keterangan']           = trim($lines[0]);
            $fillData['keterangan_lain_lain'] = isset($lines[1]) ? trim($lines[1]) : null;
        }

        foreach ($allowedFields as $field) {
            if ($request->has($field)) {
                $val = $request->input($field);
                // Simpan nilai apa adanya, termasuk string kosong → null
                $fillData[$field] = ($val !== '' && $val !== null) ? $val : null;
            }
        }

        // nm_penerima khusus — ambil langsung dari request
        $fillData['nm_penerima'] = $request->input('nm_penerima') ?: null;

        Permintaan::create($fillData);

        return redirect()->back()->with('success', 'Permintaan berhasil dikirim');
    }

    // =========================
    // USER: LIHAT PROGRES
    // =========================
    public function myRequests(Request $request)
    {
        $search       = $request->input('search');
        $layanan      = $request->input('layanan');
        $tglPengajuan = $request->input('tgl_pengajuan');
        $tglDibuat    = $request->input('tgl_dibuat');

        $query = Permintaan::where('user_id', auth()->id());

        if (!empty($search)) {
            $searchLower = strtolower($search);
            $query->where(function ($q) use ($searchLower) {
                $q->whereRaw('LOWER(no_permintaan) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(kode_rm) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(nama) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(layanan) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(COALESCE(nm_petugas_rm, \'\')) LIKE ?', ["%$searchLower%"]);
            });
        }

        if (!empty($layanan)) {
            $query->where('layanan', $layanan);
        }

        if (!empty($tglPengajuan)) {
            $query->whereDate('tanggal', $tglPengajuan);
        }

        if (!empty($tglDibuat)) {
            $query->whereDate('tgl_dibuat', $tglDibuat);
        }

        $data     = $query->orderBy('created_at', 'desc')->get();

        // Filter layanan sesuai kategori yang boleh diakses role ini
        $userRole = auth()->user()->role;
        $isGenericUser = ($userRole === 'user');

        $layanans = \App\Models\Layanan::where('is_active', true)
            ->when(!$isGenericUser, function ($q) use ($userRole) {
                $q->whereHas('kategori', function ($q2) use ($userRole) {
                    $q2->where(function ($q3) use ($userRole) {
                        $q3->whereJsonContains('roles', $userRole)
                           ->orWhere('role', $userRole);
                    });
                });
            })
            ->orderBy('nama_layanan')
            ->get();

        return view('layanan.my_requests', compact('data', 'layanans'));
    }

    // =========================
    // USER: DETAIL PERMINTAAN
    // =========================
    public function show($id)
    {
        $data = Permintaan::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

        return view('layanan.show', compact('data'));
    }

    // =========================
    // USER: CETAK BUKTI PENGAJUAN
    // =========================
    public function cetakBukti($id)
    {
        $data = Permintaan::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

        return view('layanan.bukti_pengajuan', compact('data'));
    }

    // =========================
    // USER: DOWNLOAD SURAT
    // =========================
    public function download($id)
    {
        $data = Permintaan::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

        if ($data->status !== 'selesai') {
            abort(403, 'Permintaan belum selesai diproses');
        }

        if ($data->file_surat) {
            $path = storage_path('app/public/' . $data->file_surat);
            if (!file_exists($path)) {
                abort(404, 'File tidak ditemukan');
            }
            return response()->download($path);
        }

        $layanan = Layanan::with(['biodataFields', 'isiTemplate'])
            ->where('nama_layanan', $data->layanan)
            ->first();

        if (!$layanan || empty($layanan->template_path)) {
            abort(404, 'Template surat tidak ditemukan');
        }

        return view($layanan->template_path, compact('data', 'layanan'));
    }

    // =========================
    // USER: PREVIEW SURAT
    // =========================
    public function preview($id)
    {
        $data = Permintaan::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

        if ($data->status !== 'selesai') {
            abort(403, 'Permintaan belum selesai diproses');
        }

        // File upload: tampilkan inline di browser
        if ($data->file_surat) {
            $path = storage_path('app/public/' . $data->file_surat);
            if (!file_exists($path)) {
                abort(404, 'File tidak ditemukan');
            }
            return response()->file($path, [
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
            ]);
        }

        // Template surat: render view cetak
        $layanan = Layanan::with(['biodataFields', 'isiTemplate'])
            ->where('nama_layanan', $data->layanan)
            ->first();

        if (!$layanan || empty($layanan->template_path)) {
            abort(404, 'Template surat tidak ditemukan');
        }

        return view($layanan->template_path, compact('data', 'layanan'));
    }
}
