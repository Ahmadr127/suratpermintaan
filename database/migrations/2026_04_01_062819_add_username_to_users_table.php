<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
        });

        // Isi username dari email yang sudah ada (ambil bagian sebelum @)
        \DB::table('users')->get()->each(function ($user) {
            $username = explode('@', $user->email)[0];
            // Pastikan unik
            $base = $username;
            $i = 1;
            while (\DB::table('users')->where('username', $username)->where('id', '!=', $user->id)->exists()) {
                $username = $base . $i++;
            }
            \DB::table('users')->where('id', $user->id)->update(['username' => $username]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable(false)->change();
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->string('email')->nullable(false)->change();
        });
    }
};
