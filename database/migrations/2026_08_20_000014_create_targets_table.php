<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('node_id')->constrained('kinerja_nodes')->cascadeOnDelete();
            $table->foreignId('dokumen_kinerja_id')->constrained('kinerja_dokumens')->cascadeOnDelete();
            $table->year('tahun');
            $table->string('periode', 20)->default('TAHUNAN');
            $table->decimal('nilai_target', 18, 4)->nullable();
            $table->string('nilai_teks_sumber')->nullable();
            $table->string('status', 20)->default('OFFICIAL');
            $table->string('status_perbandingan', 50)->nullable();
            $table->boolean('is_selected')->default(false);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(
                ['node_id', 'dokumen_kinerja_id', 'tahun', 'periode'],
                'uniq_target_node_dokumen_periode'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_targets');
    }
};
