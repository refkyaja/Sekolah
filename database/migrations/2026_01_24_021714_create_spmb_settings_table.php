<?php
// database/migrations/xxxx_create_spmb_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spmb_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran')->unique();
            
            // Jadwal Pendaftaran
            $table->timestamp('pendaftaran_mulai')->nullable();
            $table->timestamp('pendaftaran_selesai')->nullable();

            // Jadwal Pengumuman
            $table->timestamp('pengumuman_mulai')->nullable();
            $table->timestamp('pengumuman_selesai')->nullable();

            // Kuota Jalur (%)
            $table->integer('kuota_zonasi')->default(50);
            $table->integer('kuota_afirmasi')->default(15);
            $table->integer('kuota_prestasi')->default(30);
            $table->integer('kuota_mutasi')->default(5);
            
            // Status
            $table->enum('status_pendaftaran', ['draft', 'active', 'closed'])->nullable()->default('draft');
            $table->enum('status_pengumuman', ['draft', 'ready', 'published', 'closed'])->nullable()->default('draft');
            $table->boolean('is_published')->default(false);
            
            // Pesan Sistem
            $table->text('pesan_tunggu')->nullable();
            $table->text('pesan_selesai')->nullable();
            
            // Audit Trail
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            
            $table->timestamps();
            
            // Index
            $table->index('tahun_ajaran');
            $table->index('status_pendaftaran');
            $table->index('status_pengumuman');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spmb_settings');
    }
};