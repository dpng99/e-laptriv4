<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_relasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_node_id')->constrained('kinerja_nodes')->cascadeOnDelete();
            $table->foreignId('child_node_id')->constrained('kinerja_nodes')->cascadeOnDelete();
            $table->string('jenis_relasi', 20);
            $table->string('dasar_relasi', 20);
            $table->decimal('bobot', 8, 4)->nullable();
            $table->foreignId('dokumen_kinerja_id')->nullable()->constrained('kinerja_dokumens')->nullOnDelete();
            $table->unsignedSmallInteger('halaman_sumber')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(
                ['parent_node_id', 'child_node_id', 'jenis_relasi'],
                'uniq_relasi_kinerja'
            );
            $table->index(['parent_node_id', 'child_node_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_relasi');
    }
};
