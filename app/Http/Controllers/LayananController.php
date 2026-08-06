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
