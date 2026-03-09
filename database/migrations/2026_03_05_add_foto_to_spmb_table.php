<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spmb', function (Blueprint $table) {
            $table->string('foto_calon_siswa')->nullable()->after('catatan_admin');
        });
    }

    public function down(): void
    {
        Schema::table('spmb', function (Blueprint $table) {
            $table->dropColumn('foto_calon_siswa');
        });
    }
};
