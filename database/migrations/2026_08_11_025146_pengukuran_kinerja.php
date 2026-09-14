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
        Schema::create('pengukurans', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('pohon_kinerja_id')
                  ->constrained('pohon_kinerjas')
                  ->onDelete('cascade');

            $table->year('tahun');
            $table->unsignedTinyInteger('triwulan')->comment('1, 2, 3, 4');

            // Input Data Mentah & Target
            $table->decimal('target', 12, 2)->nullable();
            $table->decimal('pembilang_realisasi', 15, 2)->nullable(); // Nilai riil Pembilang
            $table->decimal('penyebut_realisasi', 15, 2)->nullable();  // Nilai riil Penyebut
            
            // Output Hasil Kalkulasi Engine
            $table->decimal('realisasi_aktual', 12, 2)->nullable();
            $table->decimal('capaian_persen', 8, 2)->nullable(); // Capaian % Akhir

            // Catatan Evaluasi LKJiP
            $table->text('analisis_capaian')->nullable();
            $table->text('hambatan_kendala')->nullable();
            $table->text('langkah_tindak_lanjut')->nullable();

            $table->string('created_by')->nullable();
            $table->foreign('created_by')->references('username')->on('users');
            $table->timestamps();

            // Unique constraint per indikator per periode
            $table->unique(['pohon_kinerja_id', 'tahun', 'triwulan'], 'uniq_pohon_kinerja_periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengukurans');
    }
};