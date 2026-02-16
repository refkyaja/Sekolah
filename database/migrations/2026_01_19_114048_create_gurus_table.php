<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();

            // Identitas utama
            $table->string('nama');
            $table->string('nip')->nullable()->unique();
            $table->string('email')->unique();

            // Data pribadi
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();

            // Data kepegawaian
            $table->enum('jabatan', ['guru', 'staff']);
            $table->enum('kelompok', ['A', 'B'])->nullable();
            $table->string('pendidikan_terakhir')->nullable();

            // Media
            $table->string('foto')->nullable();

            // Timestamp & soft delete
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
