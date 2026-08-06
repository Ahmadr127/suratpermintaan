<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            // 'kiri', 'kanan', atau null (tidak tampil tanggal)
            $table->string('ttd_tanggal_posisi')->nullable()->after('ttd_kanan_label_en');
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn('ttd_tanggal_posisi');
        });
    }
};
