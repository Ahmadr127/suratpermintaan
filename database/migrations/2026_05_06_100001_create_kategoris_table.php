<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('role')->nullable(); // role yang menangani permintaan kategori ini
            $table->string('warna')->default('#005654'); // warna badge
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tambah kolom kategori_id ke layanans
        Schema::table('layanans', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('id')
                  ->constrained('kategoris')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });

        Schema::dropIfExists('kategoris');
    }
};
