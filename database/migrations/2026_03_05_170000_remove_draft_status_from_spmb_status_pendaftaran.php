<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("UPDATE spmb SET status_pendaftaran = 'Menunggu Verifikasi' WHERE status_pendaftaran = 'Draft'");
        DB::statement("ALTER TABLE spmb MODIFY COLUMN status_pendaftaran VARCHAR(50) DEFAULT 'Menunggu Verifikasi'");
        DB::statement("ALTER TABLE spmb MODIFY COLUMN status_pendaftaran ENUM('Menunggu Verifikasi', 'Revisi Dokumen', 'Dokumen Verified', 'Lulus', 'Tidak Lulus') DEFAULT 'Menunggu Verifikasi'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE spmb MODIFY COLUMN status_pendaftaran VARCHAR(50) DEFAULT 'Draft'");
        DB::statement("ALTER TABLE spmb MODIFY COLUMN status_pendaftaran ENUM('Draft', 'Menunggu Verifikasi', 'Revisi Dokumen', 'Dokumen Verified', 'Lulus', 'Tidak Lulus') DEFAULT 'Draft'");
    }
};
