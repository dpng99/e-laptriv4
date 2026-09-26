<?php

namespace App\Http\Controllers;

use App\Services\WordExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ExportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'nullable|integer|between:2020,2099',
            'triwulan' => 'nullable|integer|between:1,4',
        ]);

        $tahun = (int) ($validated['tahun'] ?? date('Y'));
        $triwulan = (int) ($validated['triwulan'] ?? 1);

        return Inertia::render('Export/Index', [
            'currentTahun' => $tahun,
            'currentTriwulan' => $triwulan,
        ]);
    }

    public function exportWord(Request $request, $tahun, $triwulan, WordExportService $exportService)
    {
        $validator = Validator::make(
            ['tahun' => $tahun, 'triwulan' => $triwulan],
            [
                'tahun' => 'required|integer|between:2020,2099',
                'triwulan' => 'required|integer|between:1,4',
            ]
        );

        if ($validator->fails()) {
            abort(400, 'Parameter tahun atau triwulan tidak valid.');
        }

        $tahun = (int) $tahun;
        $triwulan = (int) $triwulan;

        Log::info('Export: LKjIP Word downloaded', [
            'username' => $request->user()?->username,
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'ip' => $request->ip(),
        ]);

        $filePath = $exportService->generateLkjiP($tahun, $triwulan);
        
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
