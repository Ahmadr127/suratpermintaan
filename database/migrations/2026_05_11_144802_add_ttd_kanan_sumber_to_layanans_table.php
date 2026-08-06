<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            // 'persetujuan' = nama_persetujuan, 'dokter' = nama_dokter
            $table->string('ttd_kanan_sumber')->default('persetujuan')->after('ttd_kanan_label_en');
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn('ttd_kanan_sumber');
        });
    }
};
