<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->string('kode_rm')->nullable()->change();
            $table->string('nama')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->string('kode_rm')->nullable(false)->change();
            $table->string('nama')->nullable(false)->change();
        });
    }
};
