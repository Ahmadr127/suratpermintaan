<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::table('permintaans', function (Blueprint $table) {
        $table->string('nm_penerima')->nullable()->change();
        $table->string('nm_petugas_rm')->nullable()->change();
    });
}

public function down()
{
    Schema::table('permintaans', function (Blueprint $table) {
        $table->string('nm_penerima')->nullable(false)->change();
        $table->string('nm_petugas_rm')->nullable(false)->change();
    });
}
};
