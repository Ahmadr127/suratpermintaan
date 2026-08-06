<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('permintaans')
            ->where('layanan', 'Pergantian Asuransi')
            ->update(['layanan' => 'Surat Keterangan Rawat Inap']);

        DB::table('permintaans')
            ->where('layanan', 'Perubahan Data Pasien')
            ->update(['layanan' => 'Surat Keterangan Rawat Jalan']);

        DB::table('permintaans')
            ->where('layanan', 'Cetak Ulang Kartu')
            ->update(['layanan' => 'Surat Kehilangan Akte Lahir']);
    }

    public function down(): void
    {
        DB::table('permintaans')
            ->where('layanan', 'Surat Keterangan Rawat Inap')
            ->update(['layanan' => 'Pergantian Asuransi']);

        DB::table('permintaans')
            ->where('layanan', 'Surat Keterangan Rawat Jalan')
            ->update(['layanan' => 'Perubahan Data Pasien']);

        DB::table('permintaans')
            ->where('layanan', 'Surat Kehilangan Akte Lahir')
            ->update(['layanan' => 'Cetak Ulang Kartu']);
    }
};