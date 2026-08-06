<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permintaans', function (Blueprint $table) {
        $table->id();
        $table->string('no_permintaan');
        $table->date('tanggal');
        $table->string('kode_rm');
        $table->string('nama');
        $table->string('layanan');
        $table->string('nm_penerima');
        $table->string('nm_petugas_rm');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaans');
    }
};
