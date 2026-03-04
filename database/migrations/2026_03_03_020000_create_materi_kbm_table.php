<?php

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
        Schema::create('materi_kbm', function (Blueprint $table) {
            $table->id();
            $table->string('mata_pelajaran');
            $table->string('judul_materi');
            $table->string('kelas');        // e.g. "Kelas 10"
            $table->string('kelompok')->nullable(); // e.g. "IPA 1"
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable(); // PDF, PowerPoint, Word, etc.
            $table->unsignedBigInteger('file_size')->nullable(); // in bytes
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_publish');
            $table->foreignId('guru_id')->nullable()->constrained('gurus')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_kbm');
    }
};
