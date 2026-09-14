<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kinerja_pengukurans', function (Blueprint $table) {
            $table->decimal('target_snapshot', 18, 4)->nullable()->after('capaian');
            $table->string('formula_key_snapshot', 80)->nullable()->after('target_snapshot');
            $table->string('formula_version_snapshot', 20)->nullable()->after('formula_key_snapshot');
            $table->string('status_capaian', 30)->nullable()->after('formula_version_snapshot')->index();
            $table->json('calculation_trace')->nullable()->after('status_capaian');
            $table->text('source_reference')->nullable()->after('calculation_trace');
            $table->text('evidence_reference')->nullable()->after('source_reference');
            $table->string('locked_by')->nullable()->after('approved_by');
            $table->timestamp('locked_at')->nullable()->after('approved_at');
            $table->timestamp('calculated_at')->nullable()->after('locked_at');
        });
    }

    public function down(): void
    {
        Schema::table('kinerja_pengukurans', function (Blueprint $table) {
            $table->dropColumn([
                'target_snapshot',
                'formula_key_snapshot',
                'formula_version_snapshot',
                'status_capaian',
                'calculation_trace',
                'source_reference',
                'evidence_reference',
                'locked_by',
                'locked_at',
                'calculated_at',
            ]);
        });
    }
};
