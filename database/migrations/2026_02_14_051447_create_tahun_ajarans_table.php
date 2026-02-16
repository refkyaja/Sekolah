<?php
// database/migrations/2024_01_01_000001_create_tahun_ajarans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahun_ajarans', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran', 9); // Contoh: 2024/2025
            $table->enum('semester', ['Ganjil', 'Genap'])->default('Ganjil');
            $table->boolean('is_aktif')->default(false);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahun_ajarans');
    }
};