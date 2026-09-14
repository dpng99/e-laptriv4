<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_nodes', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_node', 10)->index();
            $table->string('source_key', 80)->unique()->comment('Contoh: IKP:1.1');
            $table->year('tahun_mulai')->default(2025);
            $table->year('tahun_selesai')->default(2029);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_nodes');
    }
};
