<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RekamMedisUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user dengan role rekam_medis
        User::create([
            'name' => 'Rekam Medis',
            'username' => 'rekam_medis',
            'email' => 'rekam_medis@example.com',
            'password' => Hash::make('rekam_medis123'),
            'role' => 'rekam_medis',
        ]);
    }
}
