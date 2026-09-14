<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\WordExportService;

class ExportController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $triwulan = $request->input('triwulan', 1);

        return Inertia::render('Export/Index', [
            'currentTahun' => $tahun,
            'currentTriwulan' => $triwulan,
        ]);
    }

    public function exportWord(Request $request, $tahun, $triwulan, WordExportService $exportService)
    {
        $filePath = $exportService->generateLkjiP($tahun, $triwulan);
        
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
