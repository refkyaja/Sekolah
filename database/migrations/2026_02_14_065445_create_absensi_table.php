<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('guru_id');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa']);
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswas')
                ->onDelete('cascade');
            $table->foreign('guru_id')
                ->references('id')
                ->on('gurus')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};