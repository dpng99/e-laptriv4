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
        Schema::table('kinerja_rumus_indikators', function (Blueprint $table) {
            $table->string('judul_pembilang')->nullable()->after('rumus_tampilan');
            $table->string('judul_penyebut')->nullable()->after('judul_pembilang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kinerja_rumus_indikators', function (Blueprint $table) {
            $table->dropColumn(['judul_pembilang', 'judul_penyebut']);
        });
    }
};
