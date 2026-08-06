<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use App\Models\Layanan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    // =========================
    // INDEX
    // =========================
    public function index(Request $request)
    {
        $search    = $request->input('search');
        $layanan   = $request->input('layanan');
        $tanggal   = $request->input('tanggal');
        $tglDibuat = $request->input('tgl_dibuat');
        $userRole  = auth()->user()->role;

        // Cari kategori yang roles-nya mengandung role user ini (JSON array)
        $kategoriUser = \App\Models\Kategori::where(function ($q) use ($userRole) {
            $q->whereJsonContains('roles', $userRole)
              ->orWhere('role', $userRole);
        })->get();
        $kategoriIds = $kategoriUser->pluck('id');

        $query = Permintaan::query()->leftJoin('users', 'users.id', '=', 'permintaans.user_id')
                    ->select('permintaans.*');

        // Admin lihat semua. Role lain hanya lihat permintaan dari layanan di kategorinya.
        if ($userRole !== 'admin') {
            $layananDiKategori = \App\Models\Layanan::whereIn('kategori_id', $kategoriIds)
                ->pluck('nama_layanan');
            $query->whereIn('permintaans.layanan', $layananDiKategori);
        }

        if (!empty($search)) {
            $searchLower = strtolower($search);
            $query->where(function ($q) use ($searchLower) {
                $q->whereRaw('LOWER(permintaans.no_permintaan) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(permintaans.kode_rm) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(permintaans.nama) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(COALESCE(permintaans.nm_penerima, \'\')) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(COALESCE(permintaans.nm_petugas_rm, \'\')) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(permintaans.layanan) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(COALESCE(users.name, \'\')) LIKE ?', ["%$searchLower%"])
                  ->orWhereRaw('LOWER(COALESCE(permintaans.no_telepon, \'\')) LIKE ?', ["%$searchLower%"]);
            });
        }

        if (!empty($layanan)) {
            $query->where('layanan', $layanan);
        }

        if (!empty($tanggal)) {
            $query->whereDate('tanggal', $tanggal);
        }

        if (!empty($tglDibuat)) {
            $query->whereDate('tgl_dibuat', $tglDibuat);
        }

        $data = $query->with('user')->orderBy('created_at','desc')->paginate(20)->withQueryString();

        // Filter dropdown layanan disesuaikan dengan kategori user
        if ($userRole !== 'admin') {
            $layanans = \App\Models\Layanan::whereIn('kategori_id', $kategoriIds)->orderBy('nama_layanan')->get();
        } else {
            $layanans = \App\Models\Layanan::orderBy('nama_layanan')->get();
        }

        $layananTemplateMap = $layanans->pluck('template_path', 'nama_layanan')->toArray();

        return view('permintaan.index', compact('data', 'layanans', 'layananTemplateMap'));
    }

    // =========================
    // VIEW DETAIL
    // =========================
    public function viewSurat($id)
    {
        $data = Permintaan::findOrFail($id);
        return view('permintaan.view', compact('data'));
    }

    // =========================
    // CETAK DINAMIS
    // =========================
    public function cetakSurat($id)
    {
        $data = Permintaan::findOrFail($id);

        if ($data->is_lain_lain) {
            abort(403, 'Permintaan ini tidak memiliki template surat.');
        }

        $layanan = \App\Models\Layanan::with(['biodataFields', 'isiTemplate'])
            ->where('nama_layanan', $data->layanan)
            ->first();

        if (!$layanan || empty($layanan->template_path)) {
            abort(404, 'Template tidak ditemukan');
        }

        return view($layanan->template_path, compact('data', 'layanan'));
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $data    = Permintaan::findOrFail($id);
        $doctors = \App\Models\Employee::where('posisi_pekerjaan', 'like', 'DOKTER%')
                    ->orderBy('nama_karyawan')
                    ->get();

        // Ambil placeholder dari isi surat layanan ini
        $isiFields = collect();
        $layananConfig = \App\Models\Layanan::with('isiTemplate')
            ->where('nama_layanan', $data->layanan)->first();

        if ($layananConfig?->isiTemplate) {
            $teks = $layananConfig->isiTemplate->isi_id . ' ' . ($layananConfig->isiTemplate->isi_en ?? '');
            // Tambahkan juga kalimat pembuka dan penutup
            $teks .= ' ' . ($layananConfig->kalimat_pembuka ?? '') . ' ' . ($layananConfig->kalimat_pembuka_en ?? '');
            preg_match_all('/\{\{(\w+)(?:\|[^}]+)?\}\}/', $teks, $matches);
            $keys = array_unique($matches[1]);

            // Kolom yang diisi user saat pengajuan atau sudah ada di card kanan — tidak perlu tampil di isi surat
            $userFields = ['nama','umur','kode_rm','alamat','no_telepon','bangsa','nama_dokter','nama_persetujuan'];

            foreach ($keys as $key) {
                if (!in_array($key, $userFields)) {
                    $isiFields->push($key);
                }
            }
        }

        // Semua placeholder di seluruh template layanan (untuk cek relevansi field di card kanan)
        $allLayananFields = collect();
        if ($layananConfig) {
            $allTeks = implode(' ', array_filter([
                $layananConfig->isiTemplate?->isi_id,
                $layananConfig->isiTemplate?->isi_en,
                $layananConfig->kalimat_pembuka,
                $layananConfig->kalimat_pembuka_en,
            ]));
            preg_match_all('/\{\{(\w+)(?:\|[^}]+)?\}\}/', $allTeks, $m);
            $allLayananFields = collect(array_unique($m[1]));
        }

        return view('permintaan.edit', compact('data', 'doctors', 'isiFields', 'allLayananFields', 'layananConfig'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $data = Permintaan::findOrFail($id);

        // Ambil field admin dari konfigurasi layanan
        $layananConfig = \App\Models\Layanan::with(['biodataFields' => function($q) {
            $q->where('is_admin_field', true);
        }])->where('nama_layanan', $data->layanan)->first();

        $adminFieldKeys = $layananConfig?->biodataFields->pluck('field_key')->toArray() ?? [];

        // Field tetap yang selalu ada
        $updateData = [
            'nm_penerima'      => $request->nm_penerima,
            'nm_petugas_rm'    => auth()->user()->name,
            'nama_persetujuan' => $request->nama_persetujuan,
        ];

        // Field dinamis dari isi surat — simpan semua yang dikirim
        $allowedDynamic = [
            'diagnosis','nama_persetujuan',
            'tgl_masuk','tgl_keluar','tgl_periksa','tgl_berobat',
            'poliklinik','status_kehamilan','usia_kehamilan_hpht',
            'usia_kehamilan_minggu','usia_kehamilan_hari','kondisi_ibu',
            'no_surat_kelahiran','jenis_kelamin_bayi','tgl_lahir_bayi','jam_lahir_bayi',
        ];

        foreach (array_unique(array_merge($adminFieldKeys, $allowedDynamic)) as $field) {
            // Gunakan has() bukan input() agar field kosong pun tersimpan sebagai null
            if ($request->exists($field)) {
                $val = $request->input($field);
                $updateData[$field] = ($val !== '' && $val !== null) ? $val : null;
            }
        }

        $data->update($updateData);

        return redirect()->route('permintaan.index')
            ->with('success', 'Data berhasil diupdate');
    }

    // =========================
    // UPDATE STATUS
    // =========================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
        ]);

        $data = Permintaan::findOrFail($id);

        $updateData = ['status' => $request->status];

        // Isi tgl_dibuat saat status pertama kali diubah ke selesai
        if ($request->status === 'selesai' && empty($data->tgl_dibuat)) {
            $updateData['tgl_dibuat'] = now();
        }

        $data->update($updateData);

        return response()->json([
            'success'    => true,
            'status'     => $data->status,
            'tgl_dibuat' => $data->tgl_dibuat
                ? \Carbon\Carbon::parse($data->tgl_dibuat)->format('d/m/Y H:i')
                : null,
        ]);
    }

    // =========================
    // UPLOAD SURAT (untuk layanan tanpa template)
    // =========================
    public function uploadSurat(Request $request, $id)
    {
        $request->validate([
            'file_surat' => 'required|file|mimes:pdf|max:5120',
        ]);

        $data = Permintaan::findOrFail($id);

        // Hapus file lama jika ada
        if ($data->file_surat && \Storage::disk('public')->exists($data->file_surat)) {
            \Storage::disk('public')->delete($data->file_surat);
        }

        $path = $request->file('file_surat')->store('surat', 'public');
        $data->update([
            'file_surat'    => $path,
            'nm_petugas_rm' => auth()->user()->name,
        ]);

        return redirect()->route('permintaan.index')
            ->with('success', 'File surat berhasil diupload');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $data = Permintaan::findOrFail($id);
        $data->delete();

        return redirect()->route('permintaan.index')
            ->with('success','Data berhasil dihapus');
    }
}