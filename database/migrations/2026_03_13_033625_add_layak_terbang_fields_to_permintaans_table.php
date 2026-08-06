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
        Schema::table('permintaans', function (Blueprint $table) {
            $table->date('tgl_berobat')->nullable();
            $table->string('status_kehamilan')->nullable();
            $table->string('usia_kehamilan_hpht')->nullable();
            $table->integer('usia_kehamilan_minggu')->nullable();
            $table->integer('usia_kehamilan_hari')->nullable();
            $table->text('kondisi_ibu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->dropColumn([
                'tgl_berobat',
                'status_kehamilan',
                'usia_kehamilan_hpht',
                'usia_kehamilan_minggu',
                'usia_kehamilan_hari',
                'kondisi_ibu'
            ]);
        });
    }
};
