<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_ikk', function (Blueprint $table) {
            $table->foreignId('node_id')->primary()->constrained('kinerja_nodes')->cascadeOnDelete();
            $table->string('kode_ikk', 30)->unique();
            $table->string('kode_sumber', 30)->nullable();
            $table->text('nama_ikk');
            $table->string('satuan', 80)->nullable();
            $table->string('measurement_mode', 20)->default('DIRECT');
            $table->string('arah_kinerja', 30)->default('HIGHER_IS_BETTER');
            $table->text('penanggung_jawab_teks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_ikk');
    }
};
