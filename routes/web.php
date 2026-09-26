<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InputDataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware('role:operator')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/input-data', [InputDataController::class, 'index'])->name('input-data.index');
        Route::post('/input-data', [InputDataController::class, 'store'])->name('input-data.store');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/admin/rumus', App\Http\Controllers\AdminRumusController::class)->names('admin.rumus');

        Route::get('/review-data', [ReviewDataController::class, 'index'])->name('review-data.index');
        Route::get('/review-data/{id}', [ReviewDataController::class, 'show'])->name('review-data.show');

        Route::get('/export', [ExportController::class, 'index'])->name('export.index');
        Route::get('/export/word/{tahun}/{triwulan}', [ExportController::class, 'exportWord'])
            ->name('export.word')
            ->where(['tahun' => '[0-9]{4}', 'triwulan' => '[1-4]'])
            ->middleware('throttle:export');

        // Pengaturan & Builder Template LKjIP (Word)
        Route::get('/admin/template', [\App\Http\Controllers\AdminTemplateController::class, 'index'])->name('admin.template.index');
        Route::post('/admin/template/upload', [\App\Http\Controllers\AdminTemplateController::class, 'upload'])->name('admin.template.upload');
        Route::post('/admin/template/{id}/activate', [\App\Http\Controllers\AdminTemplateController::class, 'activate'])->name('admin.template.activate');
        Route::delete('/admin/template/{id}', [\App\Http\Controllers\AdminTemplateController::class, 'destroy'])->name('admin.template.destroy');
        Route::post('/admin/template/reset-default', [\App\Http\Controllers\AdminTemplateController::class, 'resetDefault'])->name('admin.template.reset');
        Route::get('/admin/template/{id}/download', [\App\Http\Controllers\AdminTemplateController::class, 'download'])->name('admin.template.download');
        Route::get('/admin/template-download-default', [\App\Http\Controllers\AdminTemplateController::class, 'downloadDefault'])->name('admin.template.download-default');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
