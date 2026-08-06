<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UnitKategoriSeeder extends Seeder
{
    public function run(): void
    {
        $unitRoles = Role::where('name', 'like', 'unit_%')->get();

        foreach ($unitRoles as $role) {
            Kategori::updateOrCreate(
                ['nama' => strtoupper($role->label)],
                [
                    'deskripsi' => 'Kategori layanan untuk unit ' . $role->label,
                    'roles'     => [$role->name],
                    'warna'     => $role->color,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Kategori unit berhasil dibuat: ' . $unitRoles->count() . ' kategori.');
    }
}
