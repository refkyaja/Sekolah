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
        Schema::table('spmb', function (Blueprint $table) {
            $table->string('provinsi_rumah')->nullable()->change();
            $table->string('kota_kabupaten_rumah')->nullable()->change();
            $table->string('kecamatan_rumah')->nullable()->change();
            $table->string('kelurahan_rumah')->nullable()->change();
            
            // Additional fields missing in the new form
            $table->integer('anak_ke')->nullable()->change();
            $table->string('tinggal_bersama')->nullable()->change();
            $table->string('status_tempat_tinggal')->nullable()->change();
            $table->string('bahasa_sehari_hari')->nullable()->change();
            $table->string('tempat_lahir_ayah')->nullable()->change();
            $table->date('tanggal_lahir_ayah')->nullable()->change();
            $table->string('tempat_lahir_ibu')->nullable()->change();
            $table->date('tanggal_lahir_ibu')->nullable()->change();
            $table->string('nomor_telepon_ibu')->nullable()->change(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spmb', function (Blueprint $table) {
            $table->string('provinsi_rumah')->nullable(false)->change();
            $table->string('kota_kabupaten_rumah')->nullable(false)->change();
            $table->string('kecamatan_rumah')->nullable(false)->change();
            $table->string('kelurahan_rumah')->nullable(false)->change();
            
            $table->integer('anak_ke')->nullable(false)->change();
            $table->string('tinggal_bersama')->nullable(false)->change();
            $table->string('status_tempat_tinggal')->nullable(false)->change();
            $table->string('bahasa_sehari_hari')->nullable(false)->change();
            $table->string('tempat_lahir_ayah')->nullable(false)->change();
            $table->date('tanggal_lahir_ayah')->nullable(false)->change();
            $table->string('tempat_lahir_ibu')->nullable(false)->change();
            $table->date('tanggal_lahir_ibu')->nullable(false)->change();
            $table->string('nomor_telepon_ibu')->nullable(false)->change();
        });
    }
};
