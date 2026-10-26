<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('redirect_to')->default('/permintaan')->after('color');
        });

        // Role 'user' (pengguna umum) tidak punya akses ke /permintaan,
        // arahkan ke halaman layanan miliknya.
        \Illuminate\Support\Facades\DB::table('roles')
            ->where('name', 'user')
            ->update(['redirect_to' => '/layanan']);
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('redirect_to');
        });
    }
};
