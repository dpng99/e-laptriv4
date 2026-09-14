<?php

namespace App\Services\Calculation;

class StatusResolver
{
    public function resolve(?float $capaian, int $triwulan, ?float $realisasi = null): string
    {
        if ($realisasi === null && $capaian === null) {
            return 'BELUM_DIINPUT';
        }

        if ($capaian === null) {
            return 'BELUM_DIINPUT';
        }

        if ($capaian >= 100.0) {
            return 'TERCAPAI';
        }

        if ($triwulan >= 4) {
            return 'TIDAK_TERCAPAI';
        }

        return 'BELUM_TERCAPAI';
    }
}
