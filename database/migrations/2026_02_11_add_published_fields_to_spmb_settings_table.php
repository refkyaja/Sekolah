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
        Schema::table('spmb_settings', function (Blueprint $table) {
            // Add published fields if they don't exist
            if (!Schema::hasColumn('spmb_settings', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            }
            
            if (!Schema::hasColumn('spmb_settings', 'published_by')) {
                $table->string('published_by')->nullable()->after('published_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spmb_settings', function (Blueprint $table) {
            $table->dropColumn(['published_at', 'published_by']);
        });
    }
};
