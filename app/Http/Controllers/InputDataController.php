<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengukuranRequest;
use App\Models\Ikk;
use App\Models\Ikp;
use App\Models\Pengukuran;
use App\Models\Target;
use App\Services\InputSchemaService;
use App\Services\TargetResolver;
use Illuminate\Support\Facades\DB;
use App\Services\PengukuranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class InputDataController extends Controller
{
    public function __construct(
        private readonly PengukuranService $pengukuranService,
        private readonly InputSchemaService $inputSchemaService,
    ) {}

    public function index(Request $request)
    {
        $unit = $request->user()->assignedUnit();
        abort_if($unit === null, 403, 'Bidang akun belum terhubung dengan unit kerja.');

        $validated = $request->validate([
            'tahun' => 'nullable|integer|between:2020,2099',
            'triwulan' => 'nullable|integer|between:1,4',
        ]);

        $tahun = (int) ($validated['tahun'] ?? date('Y'));
        $triwulan = (int) ($validated['triwulan'] ?? 1);

        $ikks = Ikk::whereHas('node.units', fn ($query) => $query->whereKey($unit->id))
            ->with([
                'node.units',
                'node.formulas.components',
                'node.parents.sk',
                'node.parents.parents.ikp',
                'node.parents.parents.parents.sp',
                'rumus',
            ])
            ->orderBy('kode_ikk')
            ->get();

        // Attach input schema and hierarchical SP/SK metadata to each IKK for dynamic rendering & grouping
        $ikks->transform(function ($ikk) {
            $ikk->input_schema = $this->inputSchemaService->getSchemaForNode($ikk->node);

            $skNode = $ikk->node?->parents?->firstWhere('jenis_node', \App\Enums\NodeType::SK);
            $spNode = null;
            if ($skNode) {
                foreach ($skNode->parents as $p) {
                    if ($p->jenis_node === \App\Enums\NodeType::SP) {
                        $spNode = $p;
                        break;
                    }
                    foreach ($p->parents as $gp) {
                        if ($gp->jenis_node === \App\Enums\NodeType::SP) {
                            $spNode = $gp;
                            break 2;
                        }
                    }
                }
            }

            $ikk->sk_id = $skNode?->id;
            $ikk->sk_kode = $skNode?->kode ?: 'SK';
            $ikk->sk_nama = $skNode?->nama ?: ($skNode?->sk?->nama_sk ?: 'Sasaran Kegiatan');
            $ikk->sp_id = $spNode?->id;
            $ikk->sp_kode = $spNode?->kode ?: 'SP';
            $ikk->sp_nama = $spNode?->nama ?: ($spNode?->sp?->nama_sp ?: 'Sasaran Program');

            return $ikk;
        });

        $nodeIdsIkk = $ikks->pluck('node_id');
        $pengukuranIkk = Pengukuran::whereIn('node_id', $nodeIdsIkk)
            ->where('unit_kerja_id', $unit->id)
            ->where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->with('inputs')
            ->get()
            ->keyBy('node_id');

        $targetIkk = app(TargetResolver::class)->resolveMany($nodeIdsIkk, $tahun, $triwulan);

        // Input level IKP canonical (MANDIRI & input_enabled)
        $ikpInputs = Ikp::whereHas('node.units', fn ($query) => $query->whereKey($unit->id))
            ->whereHas('node', fn ($query) => $query->where('input_enabled', true))
            ->with([
                'node.units',
                'node.formulas.components',
                'node.parents.sp',
                'rumus',
            ])
            ->orderBy('kode_ikp')
            ->get();

        // Attach input schema and SP metadata to each IKP
        $ikpInputs->transform(function ($ikp) {
            $ikp->input_schema = $this->inputSchemaService->getSchemaForNode($ikp->node);

            $spNode = $ikp->node?->parents?->firstWhere('jenis_node', \App\Enums\NodeType::SP);
            $ikp->sp_id = $spNode?->id;
            $ikp->sp_kode = $spNode?->kode ?: 'SP';
            $ikp->sp_nama = $spNode?->nama ?: ($spNode?->sp?->nama_sp ?: 'Sasaran Program');

            return $ikp;
        });

        $nodeIdsIkp = $ikpInputs->pluck('node_id');
        $pengukuranIkp = Pengukuran::whereIn('node_id', $nodeIdsIkp)
            ->where('unit_kerja_id', $unit->id)
            ->where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->with('inputs')
            ->get()
            ->keyBy('node_id');

        $targetIkp = app(TargetResolver::class)->resolveMany($nodeIdsIkp, $tahun, $triwulan);

        return Inertia::render('InputData/Index', [
            'selectedBiro' => $unit->nama,
            'bidangId' => trim((string) $request->user()->bidang_id),
            'currentTahun' => $tahun,
            'currentTriwulan' => $triwulan,
            'ikks' => $ikks,
            'pengukuranIkk' => $pengukuranIkk,
            'targetIkk' => $targetIkk,
            'ikpInputs' => $ikpInputs,
            'ikpMandiris' => $ikpInputs,
            'pengukuranIkp' => $pengukuranIkp,
            'targetIkp' => $targetIkp,
            'targetIkpMandiri' => $targetIkp,
        ]);
    }

    public function store(StorePengukuranRequest $request)
    {
        $validated = $request->validated();
        $unit = $request->user()->assignedUnit();
        abort_if($unit === null, 403, 'Bidang akun belum terhubung dengan unit kerja.');

        $username = $request->user()->username ?? 'system';

        // Authorize IKK ownership
        $requestedIkkCodes = collect($validated['data'] ?? [])->pluck('kode_ikk')->filter()->unique();
        if ($requestedIkkCodes->isNotEmpty()) {
            $authorizedIkkCodes = Ikk::query()
                ->whereIn('kode_ikk', $requestedIkkCodes)
                ->whereHas('node.units', fn ($query) => $query->whereKey($unit->id))
                ->pluck('kode_ikk');

            abort_if($requestedIkkCodes->diff($authorizedIkkCodes)->isNotEmpty(), 403, 'Terdapat indikator IKK yang bukan milik bidang Anda.');
        }

        // Authorize IKP ownership
        $requestedIkpCodes = collect($validated['ikp_data'] ?? [])->pluck('kode_ikp')->filter()->unique();
        if ($requestedIkpCodes->isNotEmpty()) {
            $authorizedIkpCodes = Ikp::query()
                ->whereIn('kode_ikp', $requestedIkpCodes)
                ->whereHas('node', fn ($query) => $query->where('input_enabled', true))
                ->whereHas('node.units', fn ($query) => $query->whereKey($unit->id))
                ->pluck('kode_ikp');

            abort_if($requestedIkpCodes->diff($authorizedIkpCodes)->isNotEmpty(), 403, 'Terdapat indikator IKP yang bukan input bidang Anda.');
        }

        $hasIncomplete = false;
        DB::transaction(function () use ($validated, $unit, $username, &$hasIncomplete) {
            // Persist IKK measurements
            foreach ($validated['data'] ?? [] as $row) {
                $ikk = Ikk::where('kode_ikk', $row['kode_ikk'])->with('node')->firstOrFail();
                $saved = $this->pengukuranService->storeMeasurement(
                    $ikk->node,
                    $unit->id,
                    $validated['tahun'],
                    $validated['triwulan'],
                    $row,
                    $username
                );
                $hasIncomplete = $hasIncomplete || $saved->realisasi === null;
            }

            // Persist IKP measurements
            foreach ($validated['ikp_data'] ?? [] as $row) {
                $ikp = Ikp::where('kode_ikp', $row['kode_ikp'])->with('node')->firstOrFail();
                $saved = $this->pengukuranService->storeMeasurement(
                    $ikp->node,
                    $unit->id,
                    $validated['tahun'],
                    $validated['triwulan'],
                    $row,
                    $username
                );
                $hasIncomplete = $hasIncomplete || $saved->realisasi === null;
            }

            // Recalculate derived/parent nodes
            $this->pengukuranService->recalculateAll($validated['tahun'], $validated['triwulan'], $unit->id);
        });

        Log::info('Data Mutation: Input data submitted and recalculated', [
            'username' => $username,
            'unit_id' => $unit->id,
            'unit_kode' => $unit->kode,
            'tahun' => $validated['tahun'],
            'triwulan' => $validated['triwulan'],
            'ikk_count' => count($validated['data'] ?? []),
            'ikp_count' => count($validated['ikp_data'] ?? []),
        ]);

        $totalCount = count($validated['data'] ?? []) + count($validated['ikp_data'] ?? []);
        $message = $totalCount === 1
            ? 'Data indikator berhasil disimpan dan realisasi capaian telah dikalkulasi ulang.'
            : 'Data berhasil disimpan. Realisasi dihitung sesuai formula indikator dan capaian terhadap target dihitung terpisah.';

        if ($hasIncomplete) $message = 'Data mentah tersimpan. Sebagian realisasi belum dihitung karena input belum lengkap atau rumus masih memerlukan rekonsiliasi.';

        return redirect()->back()->with('success', $message);
    }
}
