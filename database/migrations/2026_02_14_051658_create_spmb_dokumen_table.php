<?php
// database/migrations/2024_01_01_000002_create_spmb_dokumen_table.php

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
        Schema::create('spmb_dokumen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('spmb_id');
            $table->enum('jenis_dokumen', ['akte', 'kk', 'ktp', 'bukti_transfer']);
            $table->string('nama_file');
            $table->string('path_file');
            $table->string('mime_type');
            $table->integer('ukuran_file'); // dalam KB
            $table->timestamps();
            
            $table->foreign('spmb_id')->references('id')->on('spmb')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmb_dokumen');
    }
};