<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class UnitRoleSeeder extends Seeder
{
    /**
     * Generate role untuk setiap unit yang ada di tabel employees.
     * Role "user" sudah ada sebagai default untuk jabatan di bawah koordinator.
     */
    public function run(): void
    {
        $units = Employee::select('unit')
            ->distinct()
            ->orderBy('unit')
            ->pluck('unit');

        foreach ($units as $unit) {
            $slug = 'unit_' . Str::slug(strtolower($unit), '_');

            Role::updateOrCreate(
                ['name' => $slug],
                [
                    'label'          => Str::title(strtolower($unit)),
                    'description'    => 'Role untuk unit ' . $unit,
                    'color'          => $this->colorForUnit($unit),
                    'redirect_to'    => '/layanan',
                    'allowed_groups' => ['user'],
                ]
            );
        }

        $this->command->info('Role unit berhasil dibuat: ' . $units->count() . ' unit.');

        // Generate kategori untuk setiap role unit
        $this->call(UnitKategoriSeeder::class);
    }

    private function colorForUnit(string $unit): string
    {
        // Warna berdasarkan kategori unit
        $unit = strtoupper($unit);

        if (str_contains($unit, 'NS ') || str_contains($unit, 'RAWAT') || str_contains($unit, 'ICU') ||
            str_contains($unit, 'NICU') || str_contains($unit, 'PERINATOLOGI') || str_contains($unit, 'KAMAR BERSALIN') ||
            str_contains($unit, 'HEMODIALISA') || str_contains($unit, 'KAMAR OPERASI') || str_contains($unit, 'IGD') ||
            str_contains($unit, 'GAWAT DARURAT')) {
            return '#1a6b3c'; // hijau tua — klinis
        }

        if (str_contains($unit, 'FARMASI') || str_contains($unit, 'LABORATORIUM') ||
            str_contains($unit, 'RADIOLOGI') || str_contains($unit, 'REHABILITASI') ||
            str_contains($unit, 'KTKA') || str_contains($unit, 'GIZI') || str_contains($unit, 'CSSD')) {
            return '#0a5a8a'; // biru — penunjang medis
        }

        if (str_contains($unit, 'KEUANGAN') || str_contains($unit, 'AKUNTANSI') ||
            str_contains($unit, 'KASIR') || str_contains($unit, 'MARKETING') ||
            str_contains($unit, 'LOGISTIK') || str_contains($unit, 'PENGADAAN')) {
            return '#7d4e00'; // coklat — keuangan/bisnis
        }

        if (str_contains($unit, 'SDM') || str_contains($unit, 'LEGAL') ||
            str_contains($unit, 'SEKRETARIAT') || str_contains($unit, 'UMUM') ||
            str_contains($unit, 'ADMIN') || str_contains($unit, 'IT')) {
            return '#5a2d82'; // ungu — administrasi
        }

        return '#4a6741'; // default hijau abu
    }
}
