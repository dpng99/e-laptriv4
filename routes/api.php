<?php

use App\Http\Controllers\Api\SerenataPanevApiController;
use App\Http\Middleware\VerifySerenataApiSignature;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/serenata-panev')
    ->middleware(['throttle:serenata-api', VerifySerenataApiSignature::class])
    ->group(function () {
        // Endpoint 1: Khusus Modul Nilai IKP di SERENATA PANEV
        Route::get('/ikp/nilai', [SerenataPanevApiController::class, 'nilai'])
            ->name('api.serenata.ikp.nilai');

        // Endpoint 2: Khusus Modul Narasi IKP di SERENATA PANEV
        Route::get('/ikp/narasi', [SerenataPanevApiController::class, 'narasi'])
            ->name('api.serenata.ikp.narasi');
    });
