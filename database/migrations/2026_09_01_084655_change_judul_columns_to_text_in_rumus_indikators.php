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
            $table->text('judul_pembilang')->nullable()->change();
            $table->text('judul_penyebut')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('kinerja_rumus_indikators', function (Blueprint $table) {
            $table->string('judul_pembilang')->nullable()->change();
            $table->string('judul_penyebut')->nullable()->change();
        });
    }
};
