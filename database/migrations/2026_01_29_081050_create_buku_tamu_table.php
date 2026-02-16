<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_tamu', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('instansi')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->date('tanggal_kunjungan');
            $table->time('jam_kunjungan');
            $table->text('tujuan_kunjungan');
            $table->text('pesan_kesan')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('status')->default('pending'); // pending, approved, rejected, completed
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_tamu');
    }
};