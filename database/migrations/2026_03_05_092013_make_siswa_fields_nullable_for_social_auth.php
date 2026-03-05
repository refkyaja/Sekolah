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
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->change();
            $table->string('tempat_lahir', 100)->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->string('nama_ayah', 255)->nullable()->change();
            $table->string('nama_ibu', 255)->nullable()->change();
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable()->change();
            $table->date('tanggal_masuk')->nullable()->change();
            $table->text('alamat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('nik', 16)->nullable(false)->change();
            $table->string('tempat_lahir', 100)->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->string('nama_ayah', 255)->nullable(false)->change();
            $table->string('nama_ibu', 255)->nullable(false)->change();
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable(false)->change();
            $table->date('tanggal_masuk')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
        });
    }
};
