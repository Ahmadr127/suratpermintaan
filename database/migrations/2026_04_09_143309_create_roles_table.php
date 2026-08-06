<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();        // slug: admin, user, rekam_medis
            $table->string('label');                 // display: Admin, User, Rekam Medis
            $table->string('description')->nullable();
            $table->string('color')->default('#6c757d'); // badge color hex
            $table->timestamps();
        });

        // Seed default roles dari data yang sudah ada
        DB::table('roles')->insert([
            ['name' => 'admin',       'label' => 'Admin',       'description' => 'Akses penuh ke semua fitur',          'color' => '#922b21', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'rekam_medis', 'label' => 'Rekam Medis', 'description' => 'Petugas pengelola rekam medis',        'color' => '#0a3622', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user',        'label' => 'User',        'description' => 'Pengguna umum / pasien',               'color' => '#0a5a8a', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
