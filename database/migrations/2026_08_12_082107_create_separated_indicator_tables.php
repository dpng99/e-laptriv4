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
        Schema::disableForeignKeyConstraints();
        // 1. Drop old tables if they exist
        Schema::dropIfExists('pengukurans');
        Schema::dropIfExists('pohon_kinerjas');
        Schema::enableForeignKeyConstraints();

        // 2. Create Master Indicator Tables
        Schema::create('sp', function (Blueprint $table) {
            $table->string('kode_sp')->primary();
            $table->text('nama_kinerja');
            $table->string('unit_pengampu')->nullable();
            $table->timestamps();
        });

        Schema::create('ikp', function (Blueprint $table) {
            $table->string('kode_ikp')->primary();
            $table->string('sp_kode');
            $table->text('nama_kinerja');
            $table->enum('tipe_node', ['MANDIRI', 'AGREGATIF']);
            $table->string('unit_pengampu')->nullable();
            $table->timestamps();
            
            $table->foreign('sp_kode')->references('kode_sp')->on('sp')->onDelete('cascade');
        });

        Schema::create('sk', function (Blueprint $table) {
            $table->string('kode_sk')->primary();
            $table->string('ikp_kode');
            $table->text('nama_kinerja');
            $table->string('unit_pengampu')->nullable();
            $table->timestamps();
            
            $table->foreign('ikp_kode')->references('kode_ikp')->on('ikp')->onDelete('cascade');
        });

        Schema::create('ikk', function (Blueprint $table) {
            $table->string('kode_ikk')->primary();
            $table->string('sk_kode');
            $table->text('nama_kinerja');
            $table->string('unit_pengampu')->nullable();
            $table->timestamps();
            
            $table->foreign('sk_kode')->references('kode_sk')->on('sk')->onDelete('cascade');
        });

        // 3. Create Target Tables
        Schema::create('target_sp', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sp');
            $table->year('tahun');
            $table->unsignedTinyInteger('triwulan')->comment('1, 2, 3, 4');
            $table->decimal('target', 12, 2)->nullable();
            $table->decimal('realisasi', 15, 2)->nullable();
            $table->decimal('capaian', 8, 2)->nullable();
            $table->text('analisis_capaian')->nullable();
            $table->text('hambatan_kendala')->nullable();
            $table->text('langkah_tindak_lanjut')->nullable();
            $table->text('kendala')->nullable();
            $table->text('upaya')->nullable();
            $table->timestamps();
            
            $table->foreign('kode_sp')->references('kode_sp')->on('sp')->onDelete('cascade');
            $table->unique(['kode_sp', 'tahun', 'triwulan']);
        });

        Schema::create('target_ikp', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ikp');
            $table->year('tahun');
            $table->unsignedTinyInteger('triwulan')->comment('1, 2, 3, 4');
            $table->decimal('target', 12, 2)->nullable();
            $table->decimal('realisasi', 15, 2)->nullable();
            $table->decimal('capaian', 8, 2)->nullable();
            $table->text('analisis_capaian')->nullable();
            $table->text('hambatan_kendala')->nullable();
            $table->text('langkah_tindak_lanjut')->nullable();
            $table->text('kendala')->nullable();
            $table->text('upaya')->nullable();
            $table->timestamps();
            
            $table->foreign('kode_ikp')->references('kode_ikp')->on('ikp')->onDelete('cascade');
            $table->unique(['kode_ikp', 'tahun', 'triwulan']);
        });

        Schema::create('target_sk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sk');
            $table->year('tahun');
            $table->unsignedTinyInteger('triwulan')->comment('1, 2, 3, 4');
            $table->decimal('target', 12, 2)->nullable();
            $table->decimal('realisasi', 15, 2)->nullable();
            $table->decimal('capaian', 8, 2)->nullable();
            $table->text('analisis_capaian')->nullable();
            $table->text('hambatan_kendala')->nullable();
            $table->text('langkah_tindak_lanjut')->nullable();
            $table->text('kendala')->nullable();
            $table->text('upaya')->nullable();
            $table->timestamps();
            
            $table->foreign('kode_sk')->references('kode_sk')->on('sk')->onDelete('cascade');
            $table->unique(['kode_sk', 'tahun', 'triwulan']);
        });

        Schema::create('target_ikk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ikk');
            $table->year('tahun');
            $table->unsignedTinyInteger('triwulan')->comment('1, 2, 3, 4');
            $table->decimal('target', 12, 2)->nullable();
            $table->decimal('pembilang', 15, 2)->nullable();
            $table->decimal('penyebut', 15, 2)->nullable();
            $table->decimal('realisasi', 15, 2)->nullable();
            $table->decimal('capaian', 8, 2)->nullable();
            $table->text('analisis_capaian')->nullable();
            $table->text('hambatan_kendala')->nullable();
            $table->text('langkah_tindak_lanjut')->nullable();
            $table->text('kendala')->nullable();
            $table->text('upaya')->nullable();
            $table->timestamps();
            
            $table->foreign('kode_ikk')->references('kode_ikk')->on('ikk')->onDelete('cascade');
            $table->unique(['kode_ikk', 'tahun', 'triwulan']);
        });

        // 4. Create Rumus Table (for Leaf Nodes: IKP Mandiri and IKK)
        Schema::create('rumus_indikator', function (Blueprint $table) {
            $table->id();
            $table->string('kode_indikator')->unique()->comment('Bisa kode_ikp atau kode_ikk');
            $table->enum('tipe_formula', [
                'RATIO_PERCENTAGE',
                'INDEX_SCORE',
                'UNFAVORABLE_PERCENTAGE'
            ])->default('RATIO_PERCENTAGE');
            $table->string('nama_pembilang')->nullable();
            $table->string('nama_penyebut')->nullable();
            $table->string('satuan')->default('%');
            $table->text('deskripsi')->nullable()->comment('Untuk tooltip dan UI');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumus_indikator');
        Schema::dropIfExists('target_ikk');
        Schema::dropIfExists('target_sk');
        Schema::dropIfExists('target_ikp');
        Schema::dropIfExists('target_sp');
        Schema::dropIfExists('ikk');
        Schema::dropIfExists('sk');
        Schema::dropIfExists('ikp');
        Schema::dropIfExists('sp');
    }
};
