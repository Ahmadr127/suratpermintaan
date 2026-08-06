<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('permintaans', function (Blueprint $table) {
        $table->string('diagnosis')->nullable();
        $table->date('tgl_masuk')->nullable();
        $table->date('tgl_keluar')->nullable();
        $table->string('nama_dokter')->nullable();
        $table->string('nama_persetujuan')->nullable();
        $table->string('poliklinik')->nullable();
        $table->date('tgl_periksa')->nullable();
    });
}
};
