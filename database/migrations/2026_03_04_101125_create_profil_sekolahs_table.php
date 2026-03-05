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
        Schema::create('profil_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('sambutan_judul');
            $table->text('sambutan_teks');
            $table->string('kepsek_nama');
            $table->string('kepsek_foto')->nullable();
            $table->text('visi');
            $table->json('misi');
            $table->text('sejarah');
            $table->string('npsn');
            $table->string('status_akreditasi');
            $table->string('alamat');
            $table->string('kurikulum');
            $table->string('telepon');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_sekolahs');
    }
};
