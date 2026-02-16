<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_guru_accounts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('role')->default('guru');
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            
            // Add indexes for performance
            $table->index('guru_id');
            $table->index('status');
            $table->index('created_at');
        });
        
        // Tambahkan kolom user_id ke tabel gurus jika belum ada
        if (!Schema::hasColumn('gurus', 'user_id')) {
            Schema::table('gurus', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained('guru_accounts')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        
        Schema::dropIfExists('guru_accounts');
    }
};