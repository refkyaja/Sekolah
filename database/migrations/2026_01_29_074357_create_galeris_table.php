<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ===== TABEL GALERIS =====
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('kategori');
            $table->date('tanggal');
            $table->string('lokasi')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('is_published')->default(true);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index('kategori');
            $table->index('tanggal');
            $table->index('is_published');
        });
        
        // ===== TABEL GAMBAR GALERI =====
        Schema::create('gambar_galeri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('galeri_id')
                ->constrained('galeris')
                ->onDelete('cascade');
            $table->string('path');
            $table->string('nama_file');
            $table->string('nama_file_asli')->nullable(); // ✅ TAMBAHKAN
            $table->string('caption')->nullable();
            $table->integer('ukuran')->nullable();
            $table->string('mime_type', 50)->nullable(); // ✅ TAMBAHKAN
            $table->integer('urutan')->default(0);
            $table->timestamps();
            
            $table->index('galeri_id');
            $table->index('urutan');
            $table->index('mime_type'); // ✅ Index untuk filter
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_galeri');
        Schema::dropIfExists('galeris');
    }
};