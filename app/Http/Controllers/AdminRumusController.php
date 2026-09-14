<?php

namespace App\Http\Controllers;

use App\Models\KinerjaNode;
use App\Models\RumusIndikator;
use App\Services\Formula\FormulaVersionService;
use App\Enums\FormulaType;
use App\Enums\IndicatorDirection;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminRumusController extends Controller
{
    public function index()
    {
        // Load all nodes that could have formulas (typically IKP, IKK)
        // Mandiri nodes and Agregatif nodes have different formula treatments
        $formulas = RumusIndikator::with(['node.ikp', 'node.ikk'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($rumus) {
                $node = $rumus->node;
                $tipe = $node?->jenis_node?->value ?? '-';
                $kode = match ($tipe) {
                    'IKP' => $node?->ikp?->kode_ikp,
                    'IKK' => $node?->ikk?->kode_ikk,
                    default => '-',
                };
                
                $nama = match ($tipe) {
                    'IKP' => $node?->ikp?->nama_ikp,
                    'IKK' => $node?->ikk?->nama_ikk,
                    default => '-',
                };

                return [
                    'id' => $rumus->id,
                    'node_id' => $rumus->node_id,
                    'kode_indikator' => $kode,
                    'nama_indikator' => $nama,
                    'tipe_indikator' => $tipe,
                    'versi' => $rumus->versi,
                    'tipe_formula' => $rumus->tipe_formula?->value ?? $rumus->tipe_formula,
                    'is_active' => $rumus->is_active,
                ];
            });

        return Inertia::render('Admin/Rumus/Index', [
            'formulas' => $formulas
        ]);
    }

    public function create()
    {
        // Get nodes that don't have active formulas or all leaf nodes
        // Simplified: getting all IKP and IKK
        $nodes = KinerjaNode::with(['ikp', 'ikk'])
            ->whereIn('jenis_node', ['IKP', 'IKK'])
            ->get()
            ->map(function ($node) {
                $tipe = $node->jenis_node->value;
                $kode = match ($tipe) {
                    'IKP' => $node->ikp?->kode_ikp,
                    'IKK' => $node->ikk?->kode_ikk,
                    default => '-',
                };
                $nama = match ($tipe) {
                    'IKP' => $node->ikp?->nama_ikp,
                    'IKK' => $node->ikk?->nama_ikk,
                    default => '-',
                };
                return [
                    'id' => $node->id,
                    'kode' => $kode,
                    'nama' => $nama,
                    'tipe' => $tipe,
                ];
            })
            ->filter(fn($n) => $n['kode'] !== '-');

        return Inertia::render('Admin/Rumus/Form', [
            'nodes' => $nodes->values(),
            'formula' => null
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'node_id' => 'required|exists:kinerja_nodes,id',
            'tipe_formula' => ['required', Rule::enum(FormulaType::class)],
            'arah_kinerja' => ['required', Rule::enum(IndicatorDirection::class)],
            'rumus_tampilan' => 'nullable|string',
            'batas_capaian' => 'nullable|numeric',
            'jumlah_desimal' => 'nullable|integer|min:0|max:4',
            'judul_pembilang' => 'nullable|string',
            'judul_penyebut' => 'nullable|string',
            'is_active' => 'boolean',
            'komponen' => 'array',
            'komponen.*.kode_komponen' => 'required|string|max:80|distinct|regex:/^[A-Za-z][A-Za-z0-9_]*$/',
            'komponen.*.nama_komponen' => 'required|string',
            'komponen.*.tipe_data' => 'required|string',
            'komponen.*.bobot' => 'nullable|numeric|min:0|max:1',
            'komponen.*.urutan' => 'nullable|integer',
            'komponen.*.penjelasan' => 'nullable|string',
        ]);

        app(FormulaVersionService::class)->save($validated);

        return redirect()->route('admin.rumus.index')->with('success', 'Rumus berhasil ditambahkan');
    }

    public function edit($id)
    {
        $formula = RumusIndikator::with('components', 'node.ikp', 'node.ikk')->findOrFail($id);
        
        $nodes = KinerjaNode::with(['ikp', 'ikk'])
            ->whereIn('jenis_node', ['IKP', 'IKK'])
            ->get()
            ->map(function ($node) {
                $tipe = $node->jenis_node->value;
                $kode = match ($tipe) {
                    'IKP' => $node->ikp?->kode_ikp,
                    'IKK' => $node->ikk?->kode_ikk,
                    default => '-',
                };
                $nama = match ($tipe) {
                    'IKP' => $node->ikp?->nama_ikp,
                    'IKK' => $node->ikk?->nama_ikk,
                    default => '-',
                };
                return [
                    'id' => $node->id,
                    'kode' => $kode,
                    'nama' => $nama,
                    'tipe' => $tipe,
                ];
            })
            ->filter(fn($n) => $n['kode'] !== '-');

        // Format for frontend
        $formulaData = $formula->toArray();
        $formulaData['tipe_formula'] = $formula->tipe_formula?->value ?? $formula->tipe_formula;
        $formulaData['arah_kinerja'] = $formula->arah_kinerja?->value ?? $formula->arah_kinerja;
        $formulaData['komponen'] = $formula->components->toArray();

        return Inertia::render('Admin/Rumus/Form', [
            'nodes' => $nodes->values(),
            'formula' => $formulaData
        ]);
    }

    public function update(Request $request, $id)
    {
        $formula = RumusIndikator::findOrFail($id);

        $validated = $request->validate([
            'node_id' => 'required|exists:kinerja_nodes,id',
            'tipe_formula' => ['required', Rule::enum(FormulaType::class)],
            'arah_kinerja' => ['required', Rule::enum(IndicatorDirection::class)],
            'rumus_tampilan' => 'nullable|string',
            'batas_capaian' => 'nullable|numeric',
            'jumlah_desimal' => 'nullable|integer|min:0|max:4',
            'judul_pembilang' => 'nullable|string',
            'judul_penyebut' => 'nullable|string',
            'is_active' => 'boolean',
            'komponen' => 'array',
            'komponen.*.id' => 'nullable|exists:kinerja_komponen_rumus,id',
            'komponen.*.kode_komponen' => 'required|string|max:80|distinct|regex:/^[A-Za-z][A-Za-z0-9_]*$/',
            'komponen.*.nama_komponen' => 'required|string',
            'komponen.*.tipe_data' => 'required|string',
            'komponen.*.bobot' => 'nullable|numeric|min:0|max:1',
            'komponen.*.urutan' => 'nullable|integer',
            'komponen.*.penjelasan' => 'nullable|string',
        ]);

        app(FormulaVersionService::class)->save($validated, $formula);

        return redirect()->route('admin.rumus.index')->with('success', 'Rumus berhasil diperbarui');
    }

    public function destroy($id)
    {
        $formula = RumusIndikator::findOrFail($id);
        app(FormulaVersionService::class)->archive($formula);
        return redirect()->route('admin.rumus.index')->with('success', 'Rumus berhasil dihapus');
    }
}
