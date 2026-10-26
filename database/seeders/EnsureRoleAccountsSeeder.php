<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EnsureRoleAccountsSeeder extends Seeder
{
    /**
     * Pastikan setiap role utama memiliki minimal satu akun.
     * Role yang belum ada di tabel roles juga dibuat (mis. farmasi).
     */
    public function run(): void
    {
        // Pastikan role 'farmasi' ada (disebut di routes tapi belum di-seed)
        Role::firstOrCreate(
            ['name' => 'farmasi'],
            [
                'label' => 'Farmasi',
                'description' => 'Petugas farmasi',
                'color' => '#0a5a8a',
                'redirect_to' => '/permintaan',
                'allowed_groups' => null,
            ]
        );

        $accounts = [
            'admin' => 'Admin',
            'user' => 'User',
            'rekam_medis' => 'Rekam Medis',
            'farmasi' => 'Farmasi',
        ];

        foreach ($accounts as $role => $name) {
            if (!User::where('role', $role)->exists()) {
                User::create([
                    'name' => $name,
                    'username' => $role,
                    'email' => $role . '@example.com',
                    'password' => Hash::make('rsazra'),
                    'role' => $role,
                ]);
            }
        }
    }
}
