<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
   protected $fillable = [
    'no_permintaan',
    'layanan',
    'nama',
    'nama_suami',
    'umur',
    'alamat',
    'no_telepon',
    'no_hp',
    'tempat_lahir',
    'tgl_lahir',
    'jenis_kelamin',
    'kode_rm',
    'isi_surat',
    'tanggal',
    'nm_penerima',
    'nm_petugas_rm',
    'bangsa',

    'diagnosis',
    'poliklinik',
    'tgl_periksa',
    'tgl_masuk',
    'tgl_keluar',
    'nama_dokter',
    'nama_persetujuan',

    // field layak terbang
    'tgl_berobat',
    'status_kehamilan',
    'usia_kehamilan_hpht',
    'usia_kehamilan_minggu',
    'usia_kehamilan_hari',
    'kondisi_ibu',

    // field kehilangan akte
    'no_surat_kelahiran',
    'jenis_kelamin_bayi',
    'tgl_lahir_bayi',
    'jam_lahir_bayi',

    // field baru
    'status',
    'role',
    'user_id',
    'keterangan',
    'keterangan_lain_lain',
    'tgl_dibuat',
    'file_surat',
    'nama_peminta',
    'email_peminta',
    'no_whatsapp',
    'up',
    'jumlah_form_asuransi',
    'tgl_rencana_kirim',
    'is_lain_lain',
];

    /**
     * Relasi ke User (pengaju)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
