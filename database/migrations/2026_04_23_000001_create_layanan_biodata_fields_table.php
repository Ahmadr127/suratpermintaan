<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan_biodata_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            $table->string('label');           // Label Indonesia, e.g. "Nama"
            $table->string('label_en')->nullable(); // Label Inggris, e.g. "Name"
            $table->string('field_key');       // Key dari $data, e.g. "nama", "umur", "kode_rm"
            $table->string('suffix')->nullable();   // Suffix nilai, e.g. "Tahun", "WIB"
            $table->string('suffix_en')->nullable(); // Suffix Inggris, e.g. "years old"
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_biodata_fields');
    }
};
