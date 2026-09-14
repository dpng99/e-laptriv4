<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pohon_kinerjas', function (Blueprint $table) {
            $table->text('sumber_data')->nullable()->after('satuan');
        });
    }

    public function down(): void
    {
        Schema::table('pohon_kinerjas', function (Blueprint $table) {
            $table->dropColumn('sumber_data');
        });
    }
};
