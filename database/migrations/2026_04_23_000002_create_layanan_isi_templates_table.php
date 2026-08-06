<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan_isi_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            // Template isi surat dalam bahasa Indonesia
            // Gunakan placeholder {{field_key}} untuk data dinamis, e.g. {{nama}}, {{diagnosis}}
            // Gunakan [[bold:teks]] untuk bold, [[underline:teks]] untuk underline
            $table->text('isi_id');
            // Template isi surat dalam bahasa Inggris
            $table->text('isi_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_isi_templates');
    }
};
