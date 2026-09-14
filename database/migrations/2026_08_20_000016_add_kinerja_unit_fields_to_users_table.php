<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'kinerja_unit_kerja_id')) {
                $table->unsignedBigInteger('kinerja_unit_kerja_id')->nullable();
                $table->index('kinerja_unit_kerja_id', 'idx_users_kinerja_unit');
            }

            if (! Schema::hasColumn('users', 'kinerja_role')) {
                $table->string('kinerja_role', 50)->nullable();
                $table->index('kinerja_role', 'idx_users_kinerja_role');
            }

            if (! Schema::hasColumn('users', 'kinerja_is_active')) {
                $table->boolean('kinerja_is_active')->default(true);
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'kinerja_is_active')) {
                $table->dropColumn('kinerja_is_active');
            }

            if (Schema::hasColumn('users', 'kinerja_role')) {
                $table->dropColumn('kinerja_role');
            }

            if (Schema::hasColumn('users', 'kinerja_unit_kerja_id')) {
                $table->dropColumn('kinerja_unit_kerja_id');
            }
        });
    }
};
