<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('nama');
            $table->date('tgl_lahir')->nullable()->after('tempat_lahir');
            $table->string('jenis_kelamin')->nullable()->after('tgl_lahir');
            $table->string('no_hp')->nullable()->after('no_telepon');
            $table->string('nama_peminta')->nullable()->after('nm_penerima');
            $table->string('email_peminta')->nullable()->after('nama_peminta');
            $table->string('no_whatsapp')->nullable()->after('email_peminta');
            $table->string('up')->nullable()->after('no_whatsapp');
            $table->integer('jumlah_form_asuransi')->nullable()->after('up');
            $table->date('tgl_rencana_kirim')->nullable()->after('jumlah_form_asuransi');
        });
    }

    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir', 'tgl_lahir', 'jenis_kelamin',
                'no_hp', 'nama_peminta', 'email_peminta',
                'no_whatsapp', 'up', 'jumlah_form_asuransi', 'tgl_rencana_kirim',
            ]);
        });
    }
};
