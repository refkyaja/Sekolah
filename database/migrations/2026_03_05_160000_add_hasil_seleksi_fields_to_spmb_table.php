<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spmb', function (Blueprint $table) {
            $table->string('nisn')->nullable()->after('nik_anak');
            $table->string('no_registrasi')->nullable()->after('no_pendaftaran');
            $table->text('catatan_daftar_ulang')->nullable()->after('catatan_admin');
            $table->date('tanggal_mulai_daftar_ulang')->nullable()->after('catatan_daftar_ulang');
            $table->date('tanggal_selesai_daftar_ulang')->nullable()->after('tanggal_mulai_daftar_ulang');
        });
    }

    public function down(): void
    {
        Schema::table('spmb', function (Blueprint $table) {
            $table->dropColumn([
                'nisn',
                'no_registrasi',
                'catatan_daftar_ulang',
                'tanggal_mulai_daftar_ulang',
                'tanggal_selesai_daftar_ulang',
            ]);
        });
    }
};
