<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            // Apakah bagian Dokter & korespondensi lanjutan ditampilkan
            $table->boolean('show_dokter_section')->default(false)->after('ttd_tanggal_posisi');
            // Apakah field nama_suami ditampilkan (khusus surat kelahiran)
            $table->boolean('show_nama_suami')->default(false)->after('show_dokter_section');
            // Apakah field bangsa ditampilkan (khusus surat kelahiran)
            $table->boolean('show_bangsa')->default(false)->after('show_nama_suami');
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn(['show_dokter_section', 'show_nama_suami', 'show_bangsa']);
        });
    }
};
