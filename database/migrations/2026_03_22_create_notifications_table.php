<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');                         // e.g. 'ppdb_baru', 'status_update', 'dokumen_verified'
            $table->string('title');
            $table->text('body');
            $table->json('data')->nullable();               // extra data: url, spmb_id, dll
            $table->json('target_roles')->nullable();       // ["admin","operator"] - null = semua role
            $table->foreignId('target_user_id')->nullable()->constrained('users')->onDelete('cascade'); // notif personal
            $table->timestamp('read_at')->nullable();       // null = belum dibaca
            $table->timestamps();

            $table->index(['target_user_id', 'read_at']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
