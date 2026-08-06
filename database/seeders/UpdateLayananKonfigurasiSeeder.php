<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\LayananBiodataField;
use App\Models\LayananIsiTemplate;

class UpdateLayananKonfigurasiSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRawatInap();
        $this->seedRawatJalan();
        $this->seedLayakTerbang();
        $this->seedKehilanganAkte();
    }

    // ─────────────────────────────────────────────
    // RAWAT INAP
    // ─────────────────────────────────────────────
    private function seedRawatInap(): void
    {
        $layanan = Layanan::where('nama_layanan', 'Surat Keterangan Rawat Inap')->first();
        if (!$layanan) return;

        $layanan->update([
            'template_path'      => 'surat.template_universal',
            'judul_surat'        => 'SURAT KETERANGAN RAWAT INAP',
            'judul_surat_en'     => 'Inpatient Certificate',
            'kalimat_pembuka'    => '<span class="underline">Yang bertanda tangan di bawah ini, dokter <strong>Rumah Sakit Azra Bogor</strong>, menerangkan bahwa:</span>',
            'kalimat_pembuka_en' => '<span class="italic">The undersigned, the doctor of Azra Hospital Bogor, explained that:</span>',
            'kalimat_penutup'    => 'Demikianlah surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.',
            'kalimat_penutup_en' => 'Thus this statement was made so that those with an interest in understanding.',
            'ttd_kiri_label'     => 'Dokter yang merawat,',
            'ttd_kiri_label_en'  => 'Attending Doctor,',
            'ttd_kanan_label'    => 'Menyetujui data kesehatan saya diberikan kepada pihak ketiga',
            'ttd_kanan_label_en' => 'Approving my health data given to third parties',
            'ttd_tanggal_posisi' => 'kiri',
        ]);

        LayananBiodataField::where('layanan_id', $layanan->id)->delete();
        $fields = [
            ['label' => 'Nama',           'label_en' => 'Name',                  'field_key' => 'nama',    'suffix' => null,   'suffix_en' => null],
            ['label' => 'Umur',           'label_en' => 'Age',                   'field_key' => 'umur',    'suffix' => 'Tahun','suffix_en' => 'years old'],
            ['label' => 'No. Rekam Medis','label_en' => 'Medical Record Number', 'field_key' => 'kode_rm', 'suffix' => null,   'suffix_en' => null],
            ['label' => 'Alamat',         'label_en' => 'Address',               'field_key' => 'alamat',  'suffix' => null,   'suffix_en' => null],
        ];
        foreach ($fields as $i => $f) {
            LayananBiodataField::create(array_merge($f, ['layanan_id' => $layanan->id, 'urutan' => $i, 'is_admin_field' => false]));
        }

        LayananIsiTemplate::where('layanan_id', $layanan->id)->delete();
        LayananIsiTemplate::create([
            'layanan_id' => $layanan->id,
            'isi_id'     => 'Adalah benar pasien [[bold:Rumah Sakit Azra Bogor]], yang dirawat pada tanggal [[bold:{{tgl_masuk|date:d F Y}}]] sampai [[bold:{{tgl_keluar|date:d F Y}}]], dengan diagnosis [[bold:{{diagnosis}}]].',
            'isi_en'     => 'It is true that the patient of [[bold:Azra Hospital Bogor]], who was hospitalized from [[bold:{{tgl_masuk|date_en:F d}}]]<sup>th</sup>, {{tgl_masuk|date_en:Y}} to [[bold:{{tgl_keluar|date_en:F d}}]]<sup>th</sup>, {{tgl_keluar|date_en:Y}}, with diagnosis [[bold:{{diagnosis}}]].',
        ]);
    }

    // ─────────────────────────────────────────────
    // RAWAT JALAN
    // ─────────────────────────────────────────────
    private function seedRawatJalan(): void
    {
        $layanan = Layanan::where('nama_layanan', 'Surat Keterangan Rawat Jalan')->first();
        if (!$layanan) return;

        $layanan->update([
            'template_path'      => 'surat.template_universal',
            'judul_surat'        => 'SURAT KETERANGAN RAWAT JALAN',
            'judul_surat_en'     => 'Outpatient Certificate',
            'kalimat_pembuka'    => '<span class="underline">Yang bertanda tangan di bawah ini, dokter <strong>Rumah Sakit Azra Bogor</strong>, menerangkan bahwa:</span>',
            'kalimat_pembuka_en' => '<span class="italic">The undersigned, the doctor of Azra Hospital Bogor, explained that:</span>',
            'kalimat_penutup'    => 'Demikianlah surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.',
            'kalimat_penutup_en' => 'Thus this statement was made so that those with an interest in understanding.',
            'ttd_kiri_label'     => 'Dokter yang memeriksa,',
            'ttd_kiri_label_en'  => 'Examining Doctor,',
            'ttd_kanan_label'    => 'Menyetujui data kesehatan saya diberikan kepada pihak ketiga',
            'ttd_kanan_label_en' => 'Approving my health data given to third parties',
            'ttd_tanggal_posisi' => 'kiri',
        ]);

        LayananBiodataField::where('layanan_id', $layanan->id)->delete();
        $fields = [
            ['label' => 'Nama',           'label_en' => 'Name',                  'field_key' => 'nama',    'suffix' => null,   'suffix_en' => null],
            ['label' => 'Umur',           'label_en' => 'Age',                   'field_key' => 'umur',    'suffix' => 'Tahun','suffix_en' => 'years old'],
            ['label' => 'No. Rekam Medis','label_en' => 'Medical Record Number', 'field_key' => 'kode_rm', 'suffix' => null,   'suffix_en' => null],
            ['label' => 'Alamat',         'label_en' => 'Address',               'field_key' => 'alamat',  'suffix' => null,   'suffix_en' => null],
        ];
        foreach ($fields as $i => $f) {
            LayananBiodataField::create(array_merge($f, ['layanan_id' => $layanan->id, 'urutan' => $i, 'is_admin_field' => false]));
        }

        LayananIsiTemplate::where('layanan_id', $layanan->id)->delete();
        LayananIsiTemplate::create([
            'layanan_id' => $layanan->id,
            'isi_id'     => 'Adalah benar pasien Rumah Sakit Azra Bogor, yang berobat ke Poliklinik Spesialis {{poliklinik}} pada tanggal {{tgl_periksa|date:d F Y}}, dengan diagnosis {{diagnosis}}.',
            'isi_en'     => 'It is true that the patient of Azra Hospital Bogor, who visited the {{poliklinik}} Specialist Polyclinic on {{tgl_periksa|date_en:F j, Y}}, with diagnosis {{diagnosis}}.',
        ]);
    }

    // ─────────────────────────────────────────────
    // LAYAK TERBANG
    // ─────────────────────────────────────────────
    private function seedLayakTerbang(): void
    {
        $layanan = Layanan::where('nama_layanan', 'Surat Keterangan Layak Terbang')->first();
        if (!$layanan) return;

        $layanan->update([
            'template_path'      => 'surat.template_universal',
            'judul_surat'        => 'SURAT KETERANGAN LAYAK TERBANG',
            'judul_surat_en'     => 'Airworthy Certificate',
            'kalimat_pembuka'    => '<span class="underline">Yang bertandatangan dibawah ini, dokter <strong>Rumah Sakit Azra Bogor</strong>, menerangkan bahwa :</span>',
            'kalimat_pembuka_en' => '<span class="italic">The undersigned, the doctor of Azra Hospital Bogor, explained that:</span>',
            'kalimat_penutup'    => 'Demikianlah surat keterangan ini dibuat agar yang berkepentingan maklum.',
            'kalimat_penutup_en' => 'Thus this statement was made so that those with an interest in understanding.',
            'ttd_kiri_label'     => 'Hormat kami, Best regards,',
            'ttd_kiri_label_en'  => null,
            'ttd_kanan_label'    => null,
            'ttd_kanan_label_en' => null,
            'ttd_tanggal_posisi' => 'kiri',
        ]);

        LayananBiodataField::where('layanan_id', $layanan->id)->delete();
        $fields = [
            ['label' => 'Nama',           'label_en' => 'Name',                   'field_key' => 'nama',    'suffix' => ', Ny / Mrs', 'suffix_en' => null],
            ['label' => 'Umur',           'label_en' => 'Age',                    'field_key' => 'umur',    'suffix' => 'Tahun',      'suffix_en' => 'years old'],
            ['label' => 'No. Rekam Medis','label_en' => 'Medical Record Numbers', 'field_key' => 'kode_rm', 'suffix' => null,         'suffix_en' => null],
            ['label' => 'Alamat',         'label_en' => 'Address',                'field_key' => 'alamat',  'suffix' => null,         'suffix_en' => null],
        ];
        foreach ($fields as $i => $f) {
            LayananBiodataField::create(array_merge($f, ['layanan_id' => $layanan->id, 'urutan' => $i, 'is_admin_field' => false]));
        }

        LayananIsiTemplate::where('layanan_id', $layanan->id)->delete();

        $isi = '<span class="underline">Adalah benar pasien Rumah Sakit Azra Bogor, yang berobat pada tanggal <strong>{{tgl_berobat|date:d F Y}}</strong></span><br>'
             . '<span class="italic">It is true that the patient of Azra Hospital in Bogor, on {{tgl_berobat|date_en:F d}}<sup>th</sup>, {{tgl_berobat|date_en:Y}}</span>'
             . '<br><br>'
             . '<span class="underline">Hamil : G.P.A. <strong>{{usia_kehamilan_minggu}}</strong> Minggu + <strong>{{usia_kehamilan_hari}}</strong> Hari</span><br>'
             . '<span class="italic">Was pregnant : G.P.A. {{usia_kehamilan_minggu}} weeks + {{usia_kehamilan_hari}} days</span>'
             . '<br><br>'
             . '<span class="underline">Kondisi ibu baik dan dapat melakukan perjalanan dengan pesawat</span><br>'
             . '<span class="italic">The condition of mother is good and can travel by plane</span>';

        LayananIsiTemplate::create([
            'layanan_id' => $layanan->id,
            'isi_id'     => $isi,
            'isi_en'     => null,
        ]);
    }

    // ─────────────────────────────────────────────
    // KEHILANGAN AKTE
    // ─────────────────────────────────────────────
    private function seedKehilanganAkte(): void
    {
        $layanan = Layanan::where('nama_layanan', 'Surat Kehilangan Akte Lahir')->first();
        if (!$layanan) return;

        $layanan->update([
            'template_path'      => 'surat.template_universal',
            'judul_surat'        => 'SURAT KETERANGAN KEHILANGAN AKTE',
            'judul_surat_en'     => 'Certificate of Lost Birth Certificate',
            'kalimat_pembuka'    => '<span class="underline">Yang bertandatangan dibawah ini, dokter <strong>Rumah Sakit Azra Bogor</strong>, menerangkan bahwa:</span>',
            'kalimat_pembuka_en' => '<span class="italic">The undersigned, the doctor of Azra Hospital Bogor, explained that:</span>',
            'kalimat_penutup'    => 'Demikianlah surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.',
            'kalimat_penutup_en' => 'Thus this statement was made so that those with an interest in understanding.',
            'ttd_kiri_label'     => 'Ka.Inst. Ruang Persalinan,',
            'ttd_kiri_label_en'  => 'Head of Maternity Room,',
            'ttd_kanan_label'    => null,
            'ttd_kanan_label_en' => null,
            'ttd_tanggal_posisi' => 'kiri',
        ]);

        LayananBiodataField::where('layanan_id', $layanan->id)->delete();
        $fields = [
            ['label' => 'Nama',           'label_en' => 'Name',                  'field_key' => 'nama',    'suffix' => null, 'suffix_en' => null],
            ['label' => 'Umur',           'label_en' => 'Age',                   'field_key' => 'umur',    'suffix' => 'Tahun', 'suffix_en' => 'years old'],
            ['label' => 'No. Rekam Medis','label_en' => 'Medical Record Number', 'field_key' => 'kode_rm', 'suffix' => null, 'suffix_en' => null],
            ['label' => 'Alamat',         'label_en' => 'Address',               'field_key' => 'alamat',  'suffix' => null, 'suffix_en' => null],
        ];
        foreach ($fields as $i => $f) {
            LayananBiodataField::create(array_merge($f, ['layanan_id' => $layanan->id, 'urutan' => $i, 'is_admin_field' => false]));
        }

        LayananIsiTemplate::where('layanan_id', $layanan->id)->delete();
        LayananIsiTemplate::create([
            'layanan_id' => $layanan->id,
            'isi_id'     => 'Berdasarkan Surat Kelahiran yang pernah dikeluarkan dengan No.{{kode_rm}}/[[bold:RM/SRTLHR]]/{{no_surat_kelahiran}} adalah benar pasien [[bold:Rumah Sakit Azra Bogor]], yang telah melahirkan bayi ({{jenis_kelamin_bayi}}) pada tanggal {{tgl_lahir_bayi|date:d F Y}} pukul {{jam_lahir_bayi}} WIB.',
            'isi_en'     => 'Based on the Birth Certificate previously issued with No.{{kode_rm}}/RM/SRTLHR/{{no_surat_kelahiran}} it is true that the patient of Azra Hospital Bogor, who gave birth to a baby ({{jenis_kelamin_bayi}}) on {{tgl_lahir_bayi|date_en:F j, Y}} at {{jam_lahir_bayi}} WIB.',
        ]);
    }
}
