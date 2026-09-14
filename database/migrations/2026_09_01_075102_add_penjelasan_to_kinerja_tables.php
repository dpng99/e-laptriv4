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
        Schema::table('kinerja_ikp', function (Blueprint $table) {
            $table->text('penjelasan')->nullable()->after('nama_ikp');
        });

        Schema::table('kinerja_ikk', function (Blueprint $table) {
            $table->text('penjelasan')->nullable()->after('nama_ikk');
        });

        Schema::table('kinerja_komponen_rumus', function (Blueprint $table) {
            $table->text('penjelasan')->nullable()->after('nama_komponen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['kinerja_komponen_rumus', 'kinerja_ikk', 'kinerja_ikp'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropColumn('penjelasan');
            });
        }
    }
};
