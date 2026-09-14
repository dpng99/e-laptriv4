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
        Schema::create('pohon_kinerjas', function (Blueprint $table) {
            $table->id();
            
            // Relasi Self-Referencing (Tree/Hierarchy)
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('pohon_kinerjas')
                  ->onDelete('cascade');
                  
            // Level Cascading SAKIP
            $table->enum('level', [
                'SASARAN_PROGRAM',      // Level 1 (SP - Eselon I / JAMBIN)
                'INDIKATOR_PROGRAM',    // Level 2 (IKP / Outcome)
                'SASARAN_KEGIATAN',     // Level 3 (SK - Eselon II / Biro/Pusat)
                'INDIKATOR_KEGIATAN'    // Level 4 (IKK / Output Operasional)
            ])->index();

            // Identitas & Nomenklatur Indikator
            $table->string('kode_indikator')->index(); // Contoh: SP-1, IKP-1.1, SK-1.1.1, IKK-1.1.1.1
            $table->text('nama_kinerja');
            $table->string('unit_pengampu')->nullable(); // Biro Perencanaan, Biro Kepegawaian, Pusdaskrimti, dll.

            // Formulasi Rumus & Parameter Kalkulasi
            $table->enum('tipe_formula', [
                'RATIO_PERCENTAGE',      // Pembilang / Penyebut * 100%
                'INDEX_SCORE',           // Skor Indeks / Target Indeks * 100%
                'UNFAVORABLE_PERCENTAGE', // (1 - Pembilang/Penyebut) * 100% (Pelanggaran/Disiplin)
                'AGGREGATE_AVG'          // Rata-rata Capaian Anak Indikator
            ])->default('RATIO_PERCENTAGE');

            $table->text('rumus_deskripsi')->nullable(); // Deskripsi verbal rumus
            $table->string('nama_pembilang')->nullable(); // Contoh: "Jumlah Layanan RB Diselesaikan Tepat SLA"
            $table->string('nama_penyebut')->nullable();  // Contoh: "Total Permohonan Layanan RB Masuk"
            $table->string('satuan')->default('%');       // %, Indeks, Nilai, RS, Berkas, dll.

            // Periode Renstra Kejaksaan RI
            $table->year('tahun_mulai')->default(2025);
            $table->year('tahun_selesai')->default(2029);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pohon_kinerjas');
    }
};