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
        Schema::create('users', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->string('nama_satker');
            $table->char('bidang_id', 5);
            $table->char('role_id', 5);
            $table->boolean('is_active')->default(true);
            $table->timestamp('login_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
     
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Tempat menyimpan Hash Session Token Browser
            $table->string('user_id')->nullable()->index(); // Menyimpan username/user_id pegawai yang login
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
