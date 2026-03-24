<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('email');
            $table->string('provider_id')->nullable()->after('provider');
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('email');
            $table->string('provider_id')->nullable()->after('provider');
        });

        // Migrate existing google_id to provider_id
        DB::table('users')->whereNotNull('google_id')->update([
            'provider' => 'google',
            'provider_id' => DB::raw('google_id')
        ]);

        DB::table('siswas')->whereNotNull('google_id')->update([
            'provider' => 'google',
            'provider_id' => DB::raw('google_id')
        ]);

        // Drop google_id
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id');
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('google_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('provider_id');
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('provider_id');
        });

        // Revert data
        DB::table('users')->where('provider', 'google')->update([
            'google_id' => DB::raw('provider_id')
        ]);

        DB::table('siswas')->where('provider', 'google')->update([
            'google_id' => DB::raw('provider_id')
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['provider', 'provider_id']);
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn(['provider', 'provider_id']);
        });
    }
};
