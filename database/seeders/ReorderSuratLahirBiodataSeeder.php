<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReorderSuratLahirBiodataSeeder extends Seeder
{
    public function run(): void
    {
        // kode_rm (id 95) → urutan 3, alamat (id 72) → urutan 4
        DB::table('layanan_biodata_fields')->where('id', 95)->update(['urutan' => 3]);
        DB::table('layanan_biodata_fields')->where('id', 72)->update(['urutan' => 4]);

        $this->command->info('Urutan biodata Surat Lahir diperbarui');
    }
}
