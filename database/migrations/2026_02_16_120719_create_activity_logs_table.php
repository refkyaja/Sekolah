<?php
// database/migrations/2026_02_16_000001_create_activity_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action'); // login, logout, update_profile, change_password, etc
            $table->string('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device')->nullable(); // mobile, tablet, desktop
            $table->string('browser')->nullable();
            $table->string('platform')->nullable(); // Windows, Android, iOS, etc
            $table->string('location')->nullable(); // Kota/Negara (jika pakai API)
            $table->json('old_data')->nullable(); // Data sebelum perubahan
            $table->json('new_data')->nullable(); // Data setelah perubahan
            $table->string('status')->default('success'); // success, failed
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index(['user_id', 'created_at']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};