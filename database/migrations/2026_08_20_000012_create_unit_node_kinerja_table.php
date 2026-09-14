<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_unit_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('node_id')->constrained('kinerja_nodes')->cascadeOnDelete();
            $table->foreignId('unit_kerja_id')->constrained('kinerja_units')->cascadeOnDelete();
            $table->string('peran', 20)->default('OWNER');
            $table->decimal('bobot', 8, 4)->nullable();
            $table->timestamps();
            $table->unique(['node_id', 'unit_kerja_id', 'peran'], 'uniq_unit_node_peran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_unit_nodes');
    }
};
