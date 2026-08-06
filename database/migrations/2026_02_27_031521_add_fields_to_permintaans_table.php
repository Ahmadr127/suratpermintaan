<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {

            $table->string('status')->default('pending');
            $table->string('role')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('keterangan')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {

            $table->dropColumn(['status','role','user_id','keterangan']);

        });
    }
};