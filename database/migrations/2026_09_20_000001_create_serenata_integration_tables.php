<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('serenata_configs', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_enabled')->default(true);
            $table->string('api_key_prefix', 32)->nullable();
            $table->string('api_key_hash', 64)->nullable();
            $table->text('hmac_secret_encrypted')->nullable();
            $table->string('webhook_nilai_url', 500)->nullable();
            $table->string('webhook_narasi_url', 500)->nullable();
            $table->text('webhook_token_encrypted')->nullable();
            $table->json('allowed_ips')->nullable();
            $table->unsignedSmallInteger('rate_limit_per_minute')->default(30);
            $table->timestamp('last_rotated_at')->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('serenata_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('module_type', 20)->index(); // NILAI | NARASI
            $table->string('direction', 10)->index(); // PULL | PUSH
            $table->string('status', 20)->index(); // SUCCESS | FAILED | REJECTED
            $table->unsignedSmallInteger('http_status')->default(200);
            $table->unsignedSmallInteger('tahun')->nullable();
            $table->unsignedTinyInteger('triwulan')->nullable();
            $table->unsignedSmallInteger('ikp_count')->default(0);
            $table->string('payload_hash', 64)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('endpoint', 500)->nullable();
            $table->string('actor', 100)->nullable();
            $table->text('error_message')->nullable();
            $table->text('response_summary')->nullable();
            $table->unsignedInteger('duration_ms')->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('serenata_sync_logs');
        Schema::dropIfExists('serenata_configs');
    }
};
