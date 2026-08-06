<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
        'kategori_id',
        'nama_layanan',
        'judul_surat',
        'judul_surat_en',
        'kalimat_pembuka',
        'kalimat_pembuka_en',
        'deskripsi',
        'template_path',
        'is_active',
        'kalimat_penutup',
        'kalimat_penutup_en',
        'ttd_kiri_label',
        'ttd_kiri_label_en',
        'ttd_kanan_label',
        'ttd_kanan_label_en',
        'ttd_tanggal_posisi',
        'show_nama_dokter',
        'show_dokter_section',
        'show_nama_suami',
        'show_bangsa',
        'ttd_kanan_sumber',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function biodataFields()
    {
        return $this->hasMany(LayananBiodataField::class)->orderBy('urutan');
    }

    public function isiTemplate()
    {
        return $this->hasOne(LayananIsiTemplate::class);
    }
}
