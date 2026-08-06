<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\LayananBiodataField;

class AddKodeRmSuratLahirSeeder extends Seeder
{
    public function run(): void
    {
        $layanan = Layanan::where('nama_layanan', 'Surat Lahir')->first();
        if (!$layanan) return;

        $exists = LayananBiodataField::where('layanan_id', $layanan->id)
            ->where('field_key', 'kode_rm')->exists();

        if (!$exists) {
            $maxUrutan = LayananBiodataField::where('layanan_id', $layanan->id)->max('urutan') ?? 0;
            LayananBiodataField::create([
                'layanan_id'     => $layanan->id,
                'label'          => 'No. Rekam Medis',
                'label_en'       => 'Medical Record Number',
                'field_key'      => 'kode_rm',
                'suffix'         => null,
                'suffix_en'      => null,
                'urutan'         => $maxUrutan + 1,
                'is_admin_field' => false,
            ]);
            $this->command->info('kode_rm added to Surat Lahir');
        } else {
            $this->command->info('kode_rm already exists');
        }
    }
}
