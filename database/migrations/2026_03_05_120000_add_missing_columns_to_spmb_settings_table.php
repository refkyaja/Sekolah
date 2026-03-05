<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spmb_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('spmb_settings', 'gelombang')) {
                $table->integer('gelombang')->default(1)->after('tahun_ajaran');
            }
            if (!Schema::hasColumn('spmb_settings', 'tahun_ajaran_id')) {
                $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajarans')->after('gelombang');
            }
            if (!Schema::hasColumn('spmb_settings', 'countdown_mulai')) {
                $table->timestamp('countdown_mulai')->nullable()->after('pengumuman_selesai');
            }
            if (!Schema::hasColumn('spmb_settings', 'countdown_durasi')) {
                $table->integer('countdown_durasi')->default(7)->after('countdown_mulai');
            }
            if (!Schema::hasColumn('spmb_settings', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            }
            if (!Schema::hasColumn('spmb_settings', 'published_by')) {
                $table->foreignId('published_by')->nullable()->constrained('users')->after('published_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('spmb_settings', function (Blueprint $table) {
            $table->dropForeign(['published_by']);
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn([
                'gelombang',
                'tahun_ajaran_id',
                'countdown_mulai',
                'countdown_durasi',
                'published_at',
                'published_by',
            ]);
        });
    }
};
