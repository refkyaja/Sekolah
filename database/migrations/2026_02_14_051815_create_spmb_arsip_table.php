<?php
// database/migrations/2024_01_01_000004_create_spmb_arsip_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spmb_arsip', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spmb_asli_id');
            $table->string('no_pendaftaran');
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->string('nama_lengkap_anak');
            $table->string('nik_anak', 16);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir_anak');
            $table->enum('status_pendaftaran', ['Menunggu Verifikasi', 'Revisi Dokumen', 'Dokumen Verified', 'Lulus', 'Tidak Lulus']);
            $table->boolean('is_aktif')->default(false);
            $table->string('nomor_induk_siswa')->nullable();
            $table->json('data_lengkap'); // Menyimpan seluruh data dalam format JSON
            $table->timestamps();
            
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmb_arsip');
    }
};