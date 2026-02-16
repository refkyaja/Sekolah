<?php
// database/migrations/2024_01_01_000005_create_spmb_bukti_transfer_table.php

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
        Schema::create('spmb_bukti_transfer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spmb_id');
            $table->string('nama_pengirim');
            $table->string('bank_pengirim');
            $table->string('nomor_rekening_pengirim');
            $table->decimal('jumlah_transfer', 10, 2);
            $table->date('tanggal_transfer');
            $table->string('nama_file');
            $table->string('path_file');
            $table->enum('status_verifikasi', ['Menunggu', 'Diverifikasi Kepsek', 'Ditolak'])->default('Menunggu');
            $table->text('catatan_verifikasi')->nullable();
            $table->unsignedBigInteger('diverifikasi_kepsek_oleh')->nullable();
            $table->timestamp('tanggal_verifikasi_kepsek')->nullable();
            $table->timestamps();
            
            $table->foreign('spmb_id')->references('id')->on('spmb')->onDelete('cascade');
            $table->foreign('diverifikasi_kepsek_oleh')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmb_bukti_transfer');
    }
};