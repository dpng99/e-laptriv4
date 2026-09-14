<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_pengukurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('node_id')->constrained('kinerja_nodes')->cascadeOnDelete();
            $table->foreignId('target_id')->nullable()->constrained('kinerja_targets')->nullOnDelete();
            $table->foreignId('unit_kerja_id')->nullable()->constrained('kinerja_units')->nullOnDelete();
            $table->year('tahun');
            $table->unsignedTinyInteger('triwulan');
            $table->decimal('pembilang', 18, 4)->nullable();
            $table->decimal('penyebut', 18, 4)->nullable();
            $table->decimal('realisasi', 18, 4)->nullable();
            $table->decimal('capaian', 10, 2)->nullable();
            $table->string('status', 20)->default('DRAFT');
            $table->text('analisis_capaian')->nullable();
            $table->text('kendala')->nullable();
            $table->text('upaya')->nullable();
            // Kolom audit menyimpan username karena users memakai username sebagai primary key.
            // Sengaja tidak diberi foreign key agar tetap aman terhadap variasi tabel user lama.
            $table->string('created_by')->nullable()->index();
            $table->string('updated_by')->nullable()->index();
            $table->string('submitted_by')->nullable()->index();
            $table->string('verified_by')->nullable()->index();
            $table->string('approved_by')->nullable()->index();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->unique(['node_id', 'unit_kerja_id', 'tahun', 'triwulan'], 'uniq_pengukuran_node_unit');
            $table->index(['tahun', 'triwulan', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_pengukurans');
    }
};
