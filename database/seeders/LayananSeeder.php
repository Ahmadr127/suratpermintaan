<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanans = [
            [
                'nama_layanan' => 'Surat Keterangan Rawat Inap',
                'deskripsi' => 'Surat keterangan untuk pasien yang menjalani rawat inap',
                'template_path' => 'surat.rawat_inap',
                'is_active' => 1
            ],
            [
                'nama_layanan' => 'Surat Keterangan Rawat Jalan',
                'deskripsi' => 'Surat keterangan untuk pasien yang menjalani rawat jalan',
                'template_path' => 'surat.rawat_jalan',
                'is_active' => 1
            ],
            [
                'nama_layanan' => 'Surat Kehilangan Akte Lahir',
                'deskripsi' => 'Surat keterangan kehilangan akte kelahiran',
                'template_path' => 'surat.kehilangan_akte',
                'is_active' => 1
            ],
            [
                'nama_layanan' => 'Surat Keterangan Layak Terbang',
                'deskripsi' => 'Surat keterangan layak terbang untuk ibu hamil',
                'template_path' => 'surat.layak_terbang',
                'is_active' => 1
            ],
        ];

        foreach ($layanans as $layanan) {
            Layanan::firstOrCreate(
                ['nama_layanan' => $layanan['nama_layanan']],
                $layanan
            );
        }
    }
}
