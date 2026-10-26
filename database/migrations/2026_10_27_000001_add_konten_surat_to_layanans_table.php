<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->longText('konten_surat')->nullable()->after('kalimat_pembuka_en');
            $table->longText('konten_surat_en')->nullable()->after('konten_surat');
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn(['konten_surat', 'konten_surat_en']);
        });
    }
};
