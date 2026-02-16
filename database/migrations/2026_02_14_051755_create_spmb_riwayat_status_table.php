<?php
// database/migrations/2024_01_01_000003_create_spmb_riwayat_status_table.php

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
        Schema::create('spmb_riwayat_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spmb_id');
            $table->string('status_sebelumnya')->nullable();
            $table->enum('status_baru', ['Diterima', 'Menunggu Verifikasi', 'Mundur']);
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('diubah_oleh');
            $table->string('role_pengubah');
            $table->timestamps();
            
            $table->foreign('spmb_id')->references('id')->on('spmb')->onDelete('cascade');
            $table->foreign('diubah_oleh')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmb_riwayat_status');
    }
};