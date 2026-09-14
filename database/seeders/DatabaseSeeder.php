<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DokumenKinerjaSeeder::class,
            UnitKerjaSeeder::class,
            UnitKerjaUserSeeder::class,
            SsSeeder::class,
            IkssSeeder::class,
            SpSeeder::class,
            IkpSeeder::class,
            SkSeeder::class,
            IkkSeeder::class,
            ReferensiNodeSeeder::class,
            RelasiKinerjaSeeder::class,
            UnitNodeKinerjaSeeder::class,
            RumusIndikatorSeeder::class,
            TargetSeeder::class,
            CascadingArchitectureSeeder::class,
            //Pengukuran2025Seeder::class,
        ]);
    }
}
