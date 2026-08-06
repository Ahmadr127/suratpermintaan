<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->string('no_surat_kelahiran')->nullable()->after('kondisi_ibu');
            $table->string('jenis_kelamin_bayi')->nullable()->after('no_surat_kelahiran'); // Laki-laki / Perempuan
            $table->date('tgl_lahir_bayi')->nullable()->after('jenis_kelamin_bayi');
            $table->string('jam_lahir_bayi')->nullable()->after('tgl_lahir_bayi');
        });
    }

    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->dropColumn(['no_surat_kelahiran', 'jenis_kelamin_bayi', 'tgl_lahir_bayi', 'jam_lahir_bayi']);
        });
    }
};
