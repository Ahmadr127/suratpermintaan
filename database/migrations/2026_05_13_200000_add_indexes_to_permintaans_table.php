<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('layanan');
            $table->index('status');
            $table->index('created_at');
            $table->index('tanggal');
            $table->index('tgl_dibuat');
        });
    }

    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['layanan']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['tanggal']);
            $table->dropIndex(['tgl_dibuat']);
        });
    }
};
