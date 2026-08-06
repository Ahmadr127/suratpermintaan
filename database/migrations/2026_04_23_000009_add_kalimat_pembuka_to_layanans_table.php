<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->text('kalimat_pembuka')->nullable()->after('judul_surat_en');
            $table->text('kalimat_pembuka_en')->nullable()->after('kalimat_pembuka');
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn(['kalimat_pembuka', 'kalimat_pembuka_en']);
        });
    }
};
