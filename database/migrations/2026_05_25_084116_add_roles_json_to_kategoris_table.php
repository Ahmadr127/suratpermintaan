<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            // Tambah kolom roles (JSON array) setelah kolom role lama
            $table->json('roles')->nullable()->after('role');
        });

        // Migrasi data lama: salin nilai role ke roles sebagai array
        DB::table('kategoris')->whereNotNull('role')->get()->each(function ($k) {
            DB::table('kategoris')->where('id', $k->id)->update([
                'roles' => json_encode([$k->role]),
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropColumn('roles');
        });
    }
};
