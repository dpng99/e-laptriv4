<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kinerja_nodes', function (Blueprint $table) {
            $table->string('kode', 80)->nullable()->after('source_key')->index();
            $table->text('nama')->nullable()->after('kode');
            $table->string('satuan', 80)->nullable()->after('nama');
            $table->string('calculation_type', 30)->nullable()->after('satuan')->index();
            $table->string('formula_key', 80)->nullable()->after('calculation_type');
            $table->boolean('input_enabled')->default(false)->after('formula_key');
            $table->string('measurement_scope', 30)->default('UNIT')->after('input_enabled');
        });

        Schema::table('kinerja_komponen_rumus', function (Blueprint $table) {
            $table->string('source_type', 20)->default('INPUT')->after('tipe_data');
            $table->foreignId('source_node_id')->nullable()->after('source_type')
                ->constrained('kinerja_nodes')->nullOnDelete();
            $table->string('input_key', 80)->nullable()->after('source_node_id');
            $table->string('aggregation', 20)->nullable()->after('input_key');
        });

        Schema::create('kinerja_pengukuran_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengukuran_id')->constrained('kinerja_pengukurans')->cascadeOnDelete();
            $table->foreignId('komponen_rumus_id')->nullable()->constrained('kinerja_komponen_rumus')->nullOnDelete();
            $table->string('input_key', 80);
            $table->decimal('nilai', 20, 6)->nullable();
            $table->string('nilai_teks')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['pengukuran_id', 'input_key'], 'uniq_pengukuran_input_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_pengukuran_inputs');

        Schema::table('kinerja_komponen_rumus', function (Blueprint $table) {
            $table->dropConstrainedForeignId('source_node_id');
            $table->dropColumn(['source_type', 'input_key', 'aggregation']);
        });

        Schema::table('kinerja_nodes', function (Blueprint $table) {
            $table->dropColumn([
                'kode', 'nama', 'satuan', 'calculation_type', 'formula_key',
                'input_enabled', 'measurement_scope',
            ]);
        });
    }
};
