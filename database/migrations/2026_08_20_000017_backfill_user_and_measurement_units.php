<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $bidangUnitCodes = [
            'JMBIN' => 'JAMBIN',
            'SET' => 'SET-JAMBIN',
            'REN' => 'RO-REN',
            'PEG' => 'RO-PEG',
            'KEU' => 'RO-KEU',
            'KAP' => 'RO-KAP',
            'HLN' => 'RO-HUK-HLN',
            'UMUM' => 'RO-UMUM',
            'PDTI' => 'PUSDASKRIMTI',
            'PSKPH' => 'PUSTRAJAKGAKUM',
            'PKY' => 'PKY',
        ];

        if (Schema::hasTable('users') && Schema::hasTable('kinerja_units')) {
            foreach ($bidangUnitCodes as $bidangId => $unitCode) {
                $unitId = DB::table('kinerja_units')->where('kode', $unitCode)->value('id');

                if ($unitId === null) {
                    continue;
                }

                $users = DB::table('users')->where('bidang_id', $bidangId)->get();

                foreach ($users as $user) {
                    DB::table('users')
                        ->where('username', $user->username)
                        ->update([
                            'kinerja_unit_kerja_id' => $unitId,
                            'kinerja_role' => $user->role_id,
                            'kinerja_is_active' => $user->is_active,
                        ]);
                }
            }
        }

        if (! Schema::hasTable('kinerja_pengukurans') || ! Schema::hasTable('kinerja_unit_nodes')) {
            return;
        }

        $ownerUnits = DB::table('kinerja_unit_nodes')
            ->where('peran', 'OWNER')
            ->orderBy('id')
            ->get(['node_id', 'unit_kerja_id'])
            ->unique('node_id');

        foreach ($ownerUnits as $ownerUnit) {
            DB::table('kinerja_pengukurans')
                ->where('node_id', $ownerUnit->node_id)
                ->whereNull('unit_kerja_id')
                ->update(['unit_kerja_id' => $ownerUnit->unit_kerja_id]);
        }
    }

    public function down(): void
    {
        // Data assignments are intentionally retained on rollback.
    }
};
