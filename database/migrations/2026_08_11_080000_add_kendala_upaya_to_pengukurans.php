<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengukurans', function (Blueprint $table) {
            $table->text('kendala')->nullable()->after('langkah_tindak_lanjut');
            $table->text('upaya')->nullable()->after('kendala');
        });
    }

    public function down(): void
    {
        Schema::table('pengukurans', function (Blueprint $table) {
            $table->dropColumn(['kendala', 'upaya']);
        });
    }
};
