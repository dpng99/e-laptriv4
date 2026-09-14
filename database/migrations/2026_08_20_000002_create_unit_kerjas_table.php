<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('kinerja_units')->nullOnDelete();
            $table->string('kode', 50)->unique();
            $table->string('nama');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_units');
    }
};
