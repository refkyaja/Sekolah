<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('isi_berita');
            $table->string('gambar')->nullable();
            $table->enum('status', ['draft', 'publish'])->default('draft');
            $table->dateTime('tanggal_publish');
            $table->string('penulis');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Index untuk pencarian
            $table->index('status');
            $table->index('tanggal_publish');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};