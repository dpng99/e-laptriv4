<?php

namespace App\Http\Controllers;

use App\Models\ReportTemplate;
use App\Services\WordExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminTemplateController extends Controller
{
    public function index()
    {
        $templates = ReportTemplate::with('uploader')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'name' => $t->name,
                    'file_name' => $t->file_name,
                    'file_size' => $t->file_size,
                    'is_active' => (bool) $t->is_active,
                    'description' => $t->description,
                    'uploader' => $t->uploader?->nama_satker ?? $t->uploader?->username ?? 'Admin',
                    'created_at' => $t->created_at?->format('d M Y H:i'),
                ];
            });

        $activeTemplate = $templates->firstWhere('is_active', true);

        $placeholders = [
            [
                'kategori' => 'Metadata & Header Laporan',
                'items' => [
                    ['tag' => '${tahun}', 'deskripsi' => 'Tahun Anggaran Pelaporan (contoh: 2026)'],
                    ['tag' => '${triwulan}', 'deskripsi' => 'Angka Triwulan (1, 2, 3, 4)'],
                    ['tag' => '${tw_romawi}', 'deskripsi' => 'Triwulan dalam angka Romawi (I, II, III, IV)'],
                    ['tag' => '${unit_kerja}', 'deskripsi' => 'Nama Satuan Kerja Utama (JAKSA AGUNG MUDA BIDANG PEMBINAAN)'],
                    ['tag' => '${tanggal_cetak}', 'deskripsi' => 'Tanggal dokumen diekspor (contoh: 07 September 2026)'],
                ],
            ],
            [
                'kategori' => 'Statistik Capaian Organisasi',
                'items' => [
                    ['tag' => '${total_sasaran_program}', 'deskripsi' => 'Jumlah Sasaran Program (SP) yang dilaporkan'],
                    ['tag' => '${total_ikp}', 'deskripsi' => 'Jumlah Indikator Kinerja Program (IKP) aktif'],
                    ['tag' => '${rata_rata_capaian}', 'deskripsi' => 'Rata-rata persentase capaian kinerja (%)'],
                ],
            ],
            [
                'kategori' => 'Struktur Dokumen (Bab & Halaman)',
                'items' => [
                    ['tag' => '${kata_pengantar}', 'deskripsi' => 'Teks resmi Kata Pengantar JAMBIN'],
                    ['tag' => '${ikhtisar_eksekutif}', 'deskripsi' => 'Ringkasan Ikhtisar Eksekutif dan Matriks SP'],
                    ['tag' => '${bab1_pendahuluan}', 'deskripsi' => 'Uraian lengkap BAB I (Latar Belakang s/d Struktur)'],
                    ['tag' => '${bab2_perencanaan}', 'deskripsi' => 'Uraian lengkap BAB II (Rencana Strategis & Perjanjian Kinerja)'],
                    ['tag' => '${bab3_akuntabilitas}', 'deskripsi' => 'Uraian lengkap BAB III (Formula Rumus Besar, Rincian Komponen, Capaian & Analisis)'],
                    ['tag' => '${bab4_penutup}', 'deskripsi' => 'Uraian BAB IV (Kesimpulan dan Rekomendasi Tindak Lanjut)'],
                ],
            ],
        ];

        return Inertia::render('Admin/Template/Index', [
            'templates' => $templates,
            'activeTemplate' => $activeTemplate,
            'placeholders' => $placeholders,
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:docx|max:15360',
            'description' => 'nullable|string|max:1000',
        ], [
            'file.required' => 'File template wajib dipilih.',
            'file.mimes' => 'File harus berekstensi .docx (Microsoft Word).',
            'file.max' => 'Ukuran file tidak boleh melebihi 15 MB.',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        // Ensure storage/app/templates directory exists
        if (!Storage::disk('local')->exists('templates')) {
            Storage::disk('local')->makeDirectory('templates');
        }

        $path = $file->store('templates', 'local');

        // Deactivate other templates
        ReportTemplate::query()->update(['is_active' => false]);

        ReportTemplate::create([
            'name' => $request->name,
            'file_path' => $path,
            'file_name' => $originalName,
            'file_size' => $fileSize,
            'is_active' => true,
            'description' => $request->description,
            'uploaded_by' => Auth::user()?->username,
        ]);

        return redirect()->route('admin.template.index')->with('success', 'Template Word (.docx) berhasil diunggah dan diaktifkan.');
    }

    public function activate($id)
    {
        $template = ReportTemplate::findOrFail($id);

        ReportTemplate::query()->update(['is_active' => false]);
        $template->update(['is_active' => true]);

        return redirect()->route('admin.template.index')->with('success', "Template '{$template->name}' berhasil diaktifkan sebagai template default ekspor.");
    }

    public function destroy($id)
    {
        $template = ReportTemplate::findOrFail($id);

        if (Storage::disk('local')->exists($template->file_path)) {
            Storage::disk('local')->delete($template->file_path);
        }

        $template->delete();

        return redirect()->route('admin.template.index')->with('success', "Template '{$template->name}' berhasil dihapus.");
    }

    public function resetDefault()
    {
        ReportTemplate::query()->update(['is_active' => false]);

        return redirect()->route('admin.template.index')->with('success', 'Sistem berhasil direset ke generator template bawaan resmi LKjIP JAMBIN.');
    }

    public function download($id)
    {
        $template = ReportTemplate::findOrFail($id);
        $fullPath = storage_path('app/' . $template->file_path);

        if (!file_exists($fullPath)) {
            return back()->with('error', 'File template tidak ditemukan di server.');
        }

        return response()->download($fullPath, $template->file_name);
    }

    public function downloadDefault(WordExportService $exportService)
    {
        $path = $exportService->generateMasterTemplateSample();

        return response()->download($path, 'Template_Master_LKjIP_JAMBIN.docx')->deleteFileAfterSend(true);
    }
}
