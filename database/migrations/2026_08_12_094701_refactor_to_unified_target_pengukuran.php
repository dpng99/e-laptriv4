<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // Drop old split target tables
        Schema::dropIfExists('target_ikk');
        Schema::dropIfExists('target_sk');
        Schema::dropIfExists('target_ikp');
        Schema::dropIfExists('target_sp');

        // Drop old pengukurans if still exists (from earlier migration)
        Schema::dropIfExists('pengukurans');

        Schema::enableForeignKeyConstraints();

        // 1. Create unified `target` table (annual target per indicator per year)
        Schema::create('target', function (Blueprint $table) {
            $table->id();
            $table->string('kode_indikator')->index()->comment('Kode SP/IKP/SK/IKK, contoh: SP 1, IKP 1.1, SK 1.1.1, IKK 1.1.1.1');
            $table->enum('tipe_indikator', ['SP', 'IKP', 'SK', 'IKK']);
            $table->year('tahun')->comment('Tahun target dari Renstra');
            $table->decimal('target_nilai', 12, 4)->nullable()->comment('Nilai target tahunan');
            $table->timestamps();

            $table->unique(['kode_indikator', 'tahun'], 'uniq_target_per_tahun');
        });

        // 2. Create unified `pengukuran` table (quarterly measurement)
        Schema::create('pengukuran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_indikator')->index()->comment('Referensi kode indikator SP/IKP/SK/IKK');
            $table->enum('tipe_indikator', ['SP', 'IKP', 'SK', 'IKK']);
            $table->year('tahun');
            $table->unsignedTinyInteger('triwulan')->comment('1, 2, 3, 4');

            // Input data (leaf nodes only: IKK and IKP Mandiri)
            $table->decimal('pembilang', 15, 4)->nullable()->comment('Nilai realisasi pembilang (leaf node)');
            $table->decimal('penyebut', 15, 4)->nullable()->comment('Nilai realisasi penyebut (leaf node)');

            // Output kalkulasi
            $table->decimal('realisasi', 15, 4)->nullable()->comment('Nilai realisasi final');
            $table->decimal('capaian', 8, 2)->nullable()->comment('Capaian persen (%)');

            // Narasi evaluasi
            $table->text('analisis_capaian')->nullable();
            $table->text('hambatan_kendala')->nullable();
            $table->text('langkah_tindak_lanjut')->nullable();
            $table->text('kendala')->nullable();
            $table->text('upaya')->nullable();

            $table->string('created_by')->nullable();
            $table->foreign('created_by')->references('username')->on('users');
            $table->timestamps();

            $table->unique(['kode_indikator', 'tahun', 'triwulan'], 'uniq_pengukuran_per_periode');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('pengukuran');
        Schema::dropIfExists('target');
        Schema::enableForeignKeyConstraints();
    }
};
