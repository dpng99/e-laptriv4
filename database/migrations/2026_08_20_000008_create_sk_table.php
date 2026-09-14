<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_sk', function (Blueprint $table) {
            $table->foreignId('node_id')->primary()->constrained('kinerja_nodes')->cascadeOnDelete();
            $table->string('kode_sk', 30)->unique();
            $table->text('nama_sk');
            $table->text('penanggung_jawab_teks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_sk');
    }
};
