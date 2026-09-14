<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kinerja_dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->string('jenis', 30);
            $table->string('nomor')->nullable();
            $table->text('nama');
            $table->string('versi', 30)->default('1');
            $table->year('tahun_mulai');
            $table->year('tahun_selesai');
            $table->string('status', 20)->default('BERLAKU');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kinerja_dokumens');
    }
};
