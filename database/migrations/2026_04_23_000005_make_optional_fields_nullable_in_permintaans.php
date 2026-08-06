<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->string('umur')->nullable()->change();
            $table->text('alamat')->nullable()->change();
            $table->string('no_telepon')->nullable()->change();
            $table->string('layanan')->nullable()->change();
            $table->text('isi_surat')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->string('umur')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
        });
    }
};
