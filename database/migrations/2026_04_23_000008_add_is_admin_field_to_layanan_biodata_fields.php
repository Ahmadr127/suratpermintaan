<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanan_biodata_fields', function (Blueprint $table) {
            // true = diisi admin saat edit permintaan, false = diisi user saat pengajuan
            $table->boolean('is_admin_field')->default(false)->after('urutan');
        });
    }

    public function down(): void
    {
        Schema::table('layanan_biodata_fields', function (Blueprint $table) {
            $table->dropColumn('is_admin_field');
        });
    }
};
