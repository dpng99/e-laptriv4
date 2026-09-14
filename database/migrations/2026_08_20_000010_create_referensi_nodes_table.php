<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_referensi_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('node_id')->constrained('kinerja_nodes')->cascadeOnDelete();
            $table->foreignId('dokumen_kinerja_id')->constrained('kinerja_dokumens')->cascadeOnDelete();
            $table->string('kode_sumber', 50)->nullable();
            $table->unsignedSmallInteger('halaman')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['node_id', 'dokumen_kinerja_id', 'halaman'], 'uniq_referensi_node');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_referensi_nodes');
    }
};
