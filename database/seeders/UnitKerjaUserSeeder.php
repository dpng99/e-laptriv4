<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UnitKerjaUserSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        $usersColumns = Schema::getColumnListing('users');

        if (! in_array('username', $usersColumns, true)) {
            return;
        }

        $accounts = [
            'JAMBIN' => [
                'username' => 'admin.jambin',
                'bidang_id' => 'JMBIN',
                'role_id' => 'ADMIN',
            ],
            'SET-JAMBIN' => [
                'username' => 'set.jambin',
                'bidang_id' => 'SET',
                'role_id' => 'OPR',
            ],
            'RO-REN' => [
                'username' => 'ro.ren',
                'bidang_id' => 'REN',
                'role_id' => 'OPR',
            ],
            'RO-PEG' => [
                'username' => 'ro.peg',
                'bidang_id' => 'PEG',
                'role_id' => 'OPR',
            ],
            'RO-KEU' => [
                'username' => 'ro.keu',
                'bidang_id' => 'KEU',
                'role_id' => 'OPR',
            ],
            'RO-KAP' => [
                'username' => 'ro.kap',
                'bidang_id' => 'KAP',
                'role_id' => 'OPR',
            ],
            'RO-HUK-HLN' => [
                'username' => 'ro.huk.hln',
                'bidang_id' => 'HLN',
                'role_id' => 'OPR',
            ],
            'RO-UMUM' => [
                'username' => 'ro.umum',
                'bidang_id' => 'UMUM',
                'role_id' => 'OPR',
            ],
            'PUSDASKRIMTI' => [
                'username' => 'pusdaskrimti',
                'bidang_id' => 'PDTI',
                'role_id' => 'OPR',
            ],
            'PUSTRAJAKGAKUM' => [
                'username' => 'pustrajakgakum',
                'bidang_id' => 'PSKPH',
                'role_id' => 'OPR',
            ],
            'PKY' => [
                'username' => 'pky',
                'bidang_id' => 'PKY',
                'role_id' => 'OPR',
            ],
        ];

        $units = UnitKerja::query()
            ->whereIn('kode', array_keys($accounts))
            ->get()
            ->sortBy(fn (UnitKerja $unit): int => array_search($unit->kode, array_keys($accounts), true))
            ->values();

        foreach ($units as $unit) {
            $account = $accounts[$unit->kode];

            if (DB::table('users')->where('username', $account['username'])->exists()) {
                continue;
            }

            $values = $this->filterColumns([
                'username' => $account['username'],
                'nama_satker' => $unit->nama,
                'bidang_id' => $account['bidang_id'],
                'role_id' => $account['role_id'],
                'is_active' => true,
                'kinerja_unit_kerja_id' => $unit->id,
                'kinerja_role' => $account['role_id'],
                'kinerja_is_active' => true,
                'login_at' => null,
                'password' => Hash::make(env('KINERJA_BOOTSTRAP_PASSWORD') ?: Str::password(32)),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ], $usersColumns);

            DB::table('users')->insertOrIgnore($values);
        }
    }

    /**
     * @param  array<string, mixed>  $values
     * @param  array<int, string>  $columns
     * @return array<string, mixed>
     */
    private function filterColumns(array $values, array $columns): array
    {
        return collect($values)
            ->only($columns)
            ->all();
    }
}
