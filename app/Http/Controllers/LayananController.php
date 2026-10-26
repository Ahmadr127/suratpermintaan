<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\LayananBiodataField;
use App\Models\LayananIsiTemplate;
use App\Models\Kategori;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $query = Layanan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_layanan', 'like', "%$search%")
                  ->orWhere('deskripsi', 'like', "%$search%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $layanans  = $query->with('kategori')->orderBy('created_at', 'desc')->get();
        $kategoris = \App\Models\Kategori::orderBy('nama')->get();
        return view('master.layanan.index', compact('layanans', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::where('is_active', true)->orderBy('nama')->get();
        return view('master.layanan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan'       => 'required|string|max:255',
            'kategori_id'        => 'nullable|exists:kategoris,id',
            'judul_surat'        => 'nullable|string|max:255',
            'judul_surat_en'     => 'nullable|string|max:255',
            'deskripsi'          => 'nullable|string',
            'kalimat_penutup'    => 'nullable|string',
            'kalimat_penutup_en' => 'nullable|string',
            'ttd_kiri_label'     => 'nullable|string|max:255',
            'ttd_kiri_label_en'  => 'nullable|string|max:255',
            'ttd_kanan_label'    => 'nullable|string|max:255',
            'ttd_kanan_label_en' => 'nullable|string|max:255',
        ]);

        $layanan = Layanan::create([
            'kategori_id'        => $request->kategori_id ?: null,
            'nama_layanan'       => $request->nama_layanan,
            'judul_surat'        => $request->judul_surat,
            'judul_surat_en'     => $request->judul_surat_en,
            'kalimat_pembuka'    => $request->kalimat_pembuka,
            'kalimat_pembuka_en' => $request->kalimat_pembuka_en,
            'deskripsi'          => $request->deskripsi,
            'template_path'      => 'surat.template_universal',
            'is_active'          => $request->has('is_active') ? 1 : 0,
            'kalimat_penutup'    => $request->kalimat_penutup,
            'kalimat_penutup_en' => $request->kalimat_penutup_en,
            'konten_surat'       => $request->konten_surat,
            'konten_surat_en'    => $request->konten_surat_en,
            'ttd_kiri_label'     => $request->ttd_kiri_label,
            'ttd_kiri_label_en'  => $request->ttd_kiri_label_en,
            'ttd_kanan_label'    => $request->ttd_kanan_label,
            'ttd_kanan_label_en' => $request->ttd_kanan_label_en,
            'ttd_tanggal_posisi'  => $request->ttd_tanggal_posisi,
            'ttd_kanan_sumber'    => $request->ttd_kanan_sumber ?? 'persetujuan',
            'show_dokter_section' => $request->has('show_dokter_section') ? 1 : 0,
            'show_nama_dokter'    => $request->has('show_nama_dokter') ? 1 : 0,
            'show_nama_suami'     => $request->has('show_nama_suami') ? 1 : 0,
            'show_bangsa'         => $request->has('show_bangsa') ? 1 : 0,
        ]);

        // Simpan biodata fields
        $this->saveBiodataFields($layanan->id, $request);
        // Simpan isi template
        $this->saveIsiTemplate($layanan->id, $request);

        return redirect()->route('master.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $layanan   = Layanan::with(['biodataFields', 'isiTemplate'])->findOrFail($id);
        $kategoris = Kategori::where('is_active', true)->orderBy('nama')->get();
        if (request()->expectsJson()) {
            return response()->json($layanan);
        }
        return view('master.layanan.edit', compact('layanan', 'kategoris'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_layanan'       => 'required|string|max:255',
            'kategori_id'        => 'nullable|exists:kategoris,id',
            'judul_surat'        => 'nullable|string|max:255',
            'judul_surat_en'     => 'nullable|string|max:255',
            'deskripsi'          => 'nullable|string',
            'kalimat_penutup'    => 'nullable|string',
            'kalimat_penutup_en' => 'nullable|string',
            'ttd_kiri_label'     => 'nullable|string|max:255',
            'ttd_kiri_label_en'  => 'nullable|string|max:255',
            'ttd_kanan_label'    => 'nullable|string|max:255',
            'ttd_kanan_label_en' => 'nullable|string|max:255',
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update([
            'kategori_id'        => $request->kategori_id ?: null,
            'nama_layanan'       => $request->nama_layanan,
            'judul_surat'        => $request->judul_surat,
            'judul_surat_en'     => $request->judul_surat_en,
            'kalimat_pembuka'    => $request->kalimat_pembuka,
            'kalimat_pembuka_en' => $request->kalimat_pembuka_en,
            'deskripsi'          => $request->deskripsi,
            'template_path'      => 'surat.template_universal',
            'is_active'          => $request->has('is_active') ? 1 : 0,
            'kalimat_penutup'    => $request->kalimat_penutup,
            'kalimat_penutup_en' => $request->kalimat_penutup_en,
            'konten_surat'       => $request->konten_surat,
            'konten_surat_en'    => $request->konten_surat_en,
            'ttd_kiri_label'     => $request->ttd_kiri_label,
            'ttd_kiri_label_en'  => $request->ttd_kiri_label_en,
            'ttd_kanan_label'    => $request->ttd_kanan_label,
            'ttd_kanan_label_en' => $request->ttd_kanan_label_en,
            'ttd_tanggal_posisi'  => $request->ttd_tanggal_posisi,
            'ttd_kanan_sumber'    => $request->ttd_kanan_sumber ?? 'persetujuan',
            'show_dokter_section' => $request->has('show_dokter_section') ? 1 : 0,
            'show_nama_dokter'    => $request->has('show_nama_dokter') ? 1 : 0,
            'show_nama_suami'     => $request->has('show_nama_suami') ? 1 : 0,
            'show_bangsa'         => $request->has('show_bangsa') ? 1 : 0,
        ]);
        LayananBiodataField::where('layanan_id', $id)->delete();
        $this->saveBiodataFields($id, $request);

        LayananIsiTemplate::where('layanan_id', $id)->delete();
        $this->saveIsiTemplate($id, $request);

        return redirect()->route('master.layanan.index')
            ->with('success', 'Layanan berhasil diupdate');
    }

    public function destroy(string $id)
    {
        Layanan::findOrFail($id)->delete();
        return redirect()->route('master.layanan.index')
            ->with('success', 'Layanan berhasil dihapus');
    }

    /**
     * Preview surat untuk layanan (data contoh).
     */
    public function preview(string $id)
    {
        $layanan = Layanan::with(['biodataFields', 'isiTemplate'])->findOrFail($id);

        if (empty($layanan->template_path)) {
            abort(404, 'Template tidak ditemukan');
        }

        // Data contoh untuk preview
        $data = new \App\Models\Permintaan([
            'no_permintaan' => 'REQ-PREVIEW',
            'layanan' => $layanan->nama_layanan,
            'nama' => 'Nama Contoh',
            'umur' => '30 Tahun',
            'kode_rm' => 'RM-001',
            'alamat' => 'Jl. Contoh No. 1',
            'no_telepon' => '08123456789',
            'tanggal' => now(),
            'status' => 'pending',
            'nm_penerima' => 'Penerima Contoh',
            'nm_petugas_rm' => 'Petugas Contoh',
            'nama_persetujuan' => 'Nama Persetujuan',
        ]);

        return view($layanan->template_path, compact('data', 'layanan'));
    }

    /**
     * Preview live (data dari form, belum disimpan).
     */
    public function previewLive(Request $request, string $id)
    {
        $layanan = Layanan::with(['biodataFields', 'isiTemplate'])->findOrFail($id);

        if (empty($layanan->template_path)) {
            abort(404, 'Template tidak ditemukan');
        }

        // Override skalar dari request
        $layanan->judul_surat = $request->input('judul_surat', $layanan->judul_surat);
        $layanan->judul_surat_en = $request->input('judul_surat_en', $layanan->judul_surat_en);
        $layanan->kalimat_pembuka = $request->input('kalimat_pembuka', $layanan->kalimat_pembuka);
        $layanan->kalimat_pembuka_en = $request->input('kalimat_pembuka_en', $layanan->kalimat_pembuka_en);
        $layanan->kalimat_penutup = $request->input('kalimat_penutup', $layanan->kalimat_penutup);
        $layanan->kalimat_penutup_en = $request->input('kalimat_penutup_en', $layanan->kalimat_penutup_en);
        $layanan->konten_surat = $request->input('konten_surat', $layanan->konten_surat);
        $layanan->ttd_kiri_label = $request->input('ttd_kiri_label', $layanan->ttd_kiri_label);
        $layanan->ttd_kiri_label_en = $request->input('ttd_kiri_label_en', $layanan->ttd_kiri_label_en);
        $layanan->ttd_kanan_label = $request->input('ttd_kanan_label', $layanan->ttd_kanan_label);
        $layanan->ttd_kanan_label_en = $request->input('ttd_kanan_label_en', $layanan->ttd_kanan_label_en);
        $layanan->ttd_tanggal_posisi = $request->input('ttd_tanggal_posisi', $layanan->ttd_tanggal_posisi);
        $layanan->ttd_kanan_sumber = $request->input('ttd_kanan_sumber', $layanan->ttd_kanan_sumber ?? 'persetujuan');
        $layanan->show_dokter_section = $request->has('show_dokter_section') ? 1 : 0;
        $layanan->show_nama_dokter = $request->has('show_nama_dokter') ? 1 : 0;
        $layanan->show_nama_suami = $request->has('show_nama_suami') ? 1 : 0;
        $layanan->show_bangsa = $request->has('show_bangsa') ? 1 : 0;

        // Biodata fields dari form
        $labels = $request->input('biodata_label', []);
        $labelsEn = $request->input('biodata_label_en', []);
        $keys = $request->input('biodata_field_key', []);
        $suffixes = $request->input('biodata_suffix', []);
        $suffixesEn = $request->input('biodata_suffix_en', []);
        $adminFields = $request->input('biodata_is_admin', []);

        $fields = collect();
        foreach ($keys as $i => $key) {
            if (empty($key)) continue;
            $fields->push(new \App\Models\LayananBiodataField([
                'label' => $labels[$i] ?? '',
                'label_en' => $labelsEn[$i] ?? null,
                'field_key' => $key,
                'suffix' => $suffixes[$i] ?? null,
                'suffix_en' => $suffixesEn[$i] ?? null,
                'urutan' => $i,
                'is_admin_field' => isset($adminFields[$i]) ? 1 : 0,
            ]));
        }
        $layanan->setRelation('biodataFields', $fields);

        // Isi template dari form
        $isiId = $request->input('isi_id');
        $isiEn = $request->input('isi_en');
        $layanan->setRelation('isiTemplate', $isiId ? new \App\Models\LayananIsiTemplate([
            'isi_id' => $isiId,
            'isi_en' => $isiEn,
        ]) : null);

        $data = new \App\Models\Permintaan([
            'no_permintaan' => 'REQ-PREVIEW',
            'layanan' => $layanan->nama_layanan,
            'nama' => 'Nama Contoh',
            'umur' => '30 Tahun',
            'kode_rm' => 'RM-001',
            'alamat' => 'Jl. Contoh No. 1',
            'no_telepon' => '08123456789',
            'tanggal' => now(),
            'status' => 'pending',
            'nm_penerima' => 'Penerima Contoh',
            'nm_petugas_rm' => 'Petugas Contoh',
            'nama_persetujuan' => 'Nama Persetujuan',
            'nama_dokter' => 'Dr. Contoh',
        ]);

        $preview = true;
        return view($layanan->template_path, compact('data', 'layanan', 'preview'));
    }

    // ── PRIVATE HELPERS ──────────────────────────────────────────────

    private function saveBiodataFields(int $layananId, Request $request): void
    {
        $labels      = $request->input('biodata_label', []);
        $labelsEn    = $request->input('biodata_label_en', []);
        $keys        = $request->input('biodata_field_key', []);
        $suffixes    = $request->input('biodata_suffix', []);
        $suffixsEn   = $request->input('biodata_suffix_en', []);
        $adminFields = $request->input('biodata_is_admin', []);

        foreach ($keys as $i => $key) {
            if (empty($key)) continue;
            LayananBiodataField::create([
                'layanan_id'     => $layananId,
                'label'          => $labels[$i] ?? '',
                'label_en'       => $labelsEn[$i] ?? null,
                'field_key'      => $key,
                'suffix'         => $suffixes[$i] ?? null,
                'suffix_en'      => $suffixsEn[$i] ?? null,
                'urutan'         => $i,
                'is_admin_field' => isset($adminFields[$i]) ? 1 : 0,
            ]);
        }
    }

    private function saveIsiTemplate(int $layananId, Request $request): void
    {
        $isiId = $request->input('isi_id');
        $isiEn = $request->input('isi_en');

        if ($isiId) {
            LayananIsiTemplate::create([
                'layanan_id' => $layananId,
                'isi_id'     => $isiId,
                'isi_en'     => $isiEn,
            ]);
        }
    }
}
