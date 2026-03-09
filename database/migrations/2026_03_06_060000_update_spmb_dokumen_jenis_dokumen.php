<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE spmb_dokumen MODIFY COLUMN jenis_dokumen VARCHAR(50)");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE spmb_dokumen MODIFY COLUMN jenis_dokumen ENUM('akte', 'kk', 'ktp', 'bukti_transfer')");
    }
};
