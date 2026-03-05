<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE spmb MODIFY COLUMN status_pendaftaran VARCHAR(50) DEFAULT 'Menunggu Verifikasi'");
        DB::statement("ALTER TABLE spmb MODIFY COLUMN status_pendaftaran ENUM('Menunggu Verifikasi', 'Revisi Dokumen', 'Dokumen Verified', 'Lulus', 'Tidak Lulus') DEFAULT 'Menunggu Verifikasi'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE spmb MODIFY COLUMN status_pendaftaran VARCHAR(50)");
        DB::statement("ALTER TABLE spmb MODIFY COLUMN status_pendaftaran ENUM('Menunggu Verifikasi', 'Revisi Dokumen', 'Dokumen Verified', 'Lulus', 'Tidak Lulus') DEFAULT 'Menunggu Verifikasi'");
    }
};
