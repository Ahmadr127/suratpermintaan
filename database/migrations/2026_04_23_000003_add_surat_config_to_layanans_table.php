<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            // Judul surat Indonesia
            $table->string('judul_surat')->nullable()->after('nama_layanan');
            // Judul surat Inggris
            $table->string('judul_surat_en')->nullable()->after('judul_surat');
            // Kalimat penutup (sebelum TTD)
            $table->text('kalimat_penutup')->nullable()->after('judul_surat_en');
            $table->text('kalimat_penutup_en')->nullable()->after('kalimat_penutup');
            // Label TTD kiri (dokter)
            $table->string('ttd_kiri_label')->nullable()->after('kalimat_penutup_en');
            $table->string('ttd_kiri_label_en')->nullable()->after('ttd_kiri_label');
            // Label TTD kanan (persetujuan pasien) - kosong = tidak tampil
            $table->string('ttd_kanan_label')->nullable()->after('ttd_kiri_label_en');
            $table->string('ttd_kanan_label_en')->nullable()->after('ttd_kanan_label');
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn([
                'judul_surat', 'judul_surat_en',
                'kalimat_penutup', 'kalimat_penutup_en',
                'ttd_kiri_label', 'ttd_kiri_label_en',
                'ttd_kanan_label', 'ttd_kanan_label_en',
            ]);
        });
    }
};
