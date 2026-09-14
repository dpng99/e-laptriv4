<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_rumus_indikators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('node_id')->constrained('kinerja_nodes')->cascadeOnDelete();
            $table->unsignedSmallInteger('versi')->default(1);
            $table->string('tipe_formula', 30)->default('RATIO_PERCENTAGE');
            $table->string('arah_kinerja', 30)->default('HIGHER_IS_BETTER');
            $table->longText('rumus_tampilan')->nullable();
            $table->string('status_formula', 255)->nullable();
            $table->decimal('batas_capaian', 8, 2)->nullable();
            $table->unsignedTinyInteger('jumlah_desimal')->default(2);
            $table->string('kebijakan_data_kosong', 30)->default('BLOCK');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['node_id', 'versi']);
        });

        Schema::create('kinerja_komponen_rumus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumus_indikator_id')->constrained('kinerja_rumus_indikators')->cascadeOnDelete();
            $table->string('kode_komponen', 50);
            $table->string('nama_komponen');
            $table->string('tipe_data', 20)->default('DECIMAL');
            $table->decimal('bobot', 8, 4)->nullable();
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->timestamps();
            $table->unique(['rumus_indikator_id', 'kode_komponen'], 'uniq_komponen_rumus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_komponen_rumus');
        Schema::dropIfExists('kinerja_rumus_indikators');
    }
};
