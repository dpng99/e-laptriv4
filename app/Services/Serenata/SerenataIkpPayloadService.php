<?php

namespace App\Services\Serenata;

use App\Enums\NodeType;
use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Services\TargetResolver;
use Illuminate\Support\Collection;

class SerenataIkpPayloadService
{
    public const SERENATA_JAMBIN_SATKER_ID = '005016';
    public const SERENATA_KHUSUS_IKP = 2;

    public function __construct(
        private readonly TargetResolver $targetResolver,
    ) {}

    /**
     * Build explicit quantitative/numerical payload for SERENATA PANEV - Modul Nilai IKP.
     * Guaranteed to contain ONLY IKP nodes, ONLY final IKP values (no formula components),
     * and NO narrative fields, matching SERENATA `pengukuran` (khusus = 2).
     */
    public function buildNilaiPayload(int $tahun, int $triwulan, ?string $kodeIkp = null): array
    {
        $nodes = $this->loadExplicitIkpNodes($tahun, $triwulan, $kodeIkp);
        $bulan = $triwulan * 3;

        $data = $nodes->map(function (KinerjaNode $node) use ($tahun, $triwulan, $bulan): array {
            $common = $this->extractIdentityAndContext($node, $tahun, $triwulan);
            /** @var Pengukuran|null $pengukuran */
            $pengukuran = $common['pengukuran'];
            $targetModel = $this->targetResolver->choose($node->targets, $triwulan);

            $nilaiTarget = ($pengukuran?->isFinal() || $pengukuran?->target_snapshot !== null)
                ? ($pengukuran->target_snapshot !== null ? (float) $pengukuran->target_snapshot : null)
                : ($targetModel?->nilai_target !== null ? (float) $targetModel->nilai_target : null);

            $targetTeks = $nilaiTarget !== null
                ? (string) $nilaiTarget
                : ($targetModel?->nilai_teks_sumber ?: null);

            $realisasi = $pengukuran?->realisasi !== null ? (float) $pengukuran->realisasi : null;
            $capaian = $pengukuran?->capaian !== null ? (float) $pengukuran->capaian : null;

            $statusCapaian = $this->resolveStatusCapaian($pengukuran, $capaian, $triwulan);
            $activeFormula = $node->formulas->firstWhere('is_active', true) ?? $node->formulas->first();

            $tipeKalkulasi = $activeFormula?->tipe_formula?->value
                ?? (is_string($activeFormula?->tipe_formula) ? $activeFormula->tipe_formula : null)
                ?? $node->formula_key
                ?? $node->calculation_type
                ?? 'DIRECT_VALUE';

            $arahKinerja = $activeFormula?->arah_kinerja?->value
                ?? (is_string($activeFormula?->arah_kinerja) ? $activeFormula->arah_kinerja : null)
                ?? $node->ikp?->arah_kinerja?->value
                ?? 'HIGHER_IS_BETTER';

            $satuan = $node->satuan ?: ($node->ikp?->satuan ?: '');
            $sifatNode = $this->resolveSerenataSifatNode($satuan, (string) $tipeKalkulasi, (string) $arahKinerja);

            return [
                'id_satker' => self::SERENATA_JAMBIN_SATKER_ID,
                'kode_ikp' => $common['kode_ikp'],
                'sub_indikator' => $common['kode_ikp'],
                'source_key' => $node->source_key,
                'nama_ikp' => $common['nama_ikp'],
                'kode_sp' => $common['kode_sp'],
                'nama_sp' => $common['nama_sp'],
                'unit_pengampu' => $common['unit_pengampu'],
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'bulan' => $bulan,
                'khusus' => self::SERENATA_KHUSUS_IKP,
                'satuan' => $satuan,
                'sifat_node' => $sifatNode,
                'tipe_kalkulasi' => (string) $tipeKalkulasi,
                'arah_kinerja' => (string) $arahKinerja,
                'capaian' => $realisasi,
                'nilai_akhir_ikp' => $realisasi,
                'nilai_realisasi' => $realisasi,
                'nilai_target' => $nilaiTarget,
                'target_teks' => $targetTeks,
                'nilai_capaian' => $capaian,
                'status_capaian' => $statusCapaian,
                'workflow_status' => $pengukuran?->status ?: 'BELUM_DIINPUT',
                'is_final' => $pengukuran ? ($pengukuran->isFinal() || $pengukuran->isReported()) : false,
                'updated_at' => $pengukuran?->updated_at?->toIso8601String(),
            ];
        })->values()->all();

        $payloadSha256 = hash('sha256', json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return [
            'meta' => [
                'schema_version' => '1.1',
                'module_type' => 'NILAI',
                'entity_level' => 'IKP_ONLY',
                'id_satker' => self::SERENATA_JAMBIN_SATKER_ID,
                'source_app' => 'e-Laptri Pembinaan JAMBIN',
                'target_app' => 'SERENATA PANEV - Modul Nilai IKP',
                'organization' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'bulan' => $bulan,
                'khusus' => self::SERENATA_KHUSUS_IKP,
                'total_ikp' => count($data),
                'generated_at' => now()->toIso8601String(),
                'payload_sha256' => $payloadSha256,
            ],
            'data' => $data,
        ];
    }

    /**
     * Build explicit qualitative/narrative payload for SERENATA PANEV - Modul Narasi IKP.
     * Guaranteed to contain ONLY IKP nodes and NO quantitative measurement fields,
     * mapped directly to SERENATA `pelaporan_ikp` (faktor & langkah_optimalisasi).
     */
    public function buildNarasiPayload(int $tahun, int $triwulan, ?string $kodeIkp = null): array
    {
        $nodes = $this->loadExplicitIkpNodes($tahun, $triwulan, $kodeIkp);

        $data = $nodes->map(function (KinerjaNode $node) use ($tahun, $triwulan): array {
            $common = $this->extractIdentityAndContext($node, $tahun, $triwulan);
            /** @var Pengukuran|null $pengukuran */
            $pengukuran = $common['pengukuran'];

            $analisis = $pengukuran?->analisis_capaian !== null ? trim((string) $pengukuran->analisis_capaian) : null;
            $kendala = $pengukuran?->kendala !== null ? trim((string) $pengukuran->kendala) : null;
            $upaya = $pengukuran?->upaya !== null ? trim((string) $pengukuran->upaya) : null;

            $analisis = $analisis !== '' ? $analisis : null;
            $kendala = $kendala !== '' ? $kendala : null;
            $upaya = $upaya !== '' ? $upaya : null;

            $faktor = $this->composeSerenataFaktor($analisis, $kendala);

            return [
                'id_satker' => self::SERENATA_JAMBIN_SATKER_ID,
                'kode_ikp' => $common['kode_ikp'],
                'source_key' => $node->source_key,
                'nama_ikp' => $common['nama_ikp'],
                'kode_sp' => $common['kode_sp'],
                'nama_sp' => $common['nama_sp'],
                'unit_pengampu' => $common['unit_pengampu'],
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'faktor' => $faktor,
                'langkah_optimalisasi' => $upaya,
                'langkah' => $upaya,
                'analisis_capaian' => $analisis,
                'kendala' => $kendala,
                'upaya' => $upaya,
                'source_reference' => $pengukuran?->source_reference,
                'evidence_reference' => $pengukuran?->evidence_reference,
                'is_narasi_lengkap' => ($analisis !== null && $kendala !== null && $upaya !== null),
                'workflow_status' => $pengukuran?->status ?: 'BELUM_DIINPUT',
                'updated_at' => $pengukuran?->updated_at?->toIso8601String(),
            ];
        })->values()->all();

        $payloadSha256 = hash('sha256', json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return [
            'meta' => [
                'schema_version' => '1.1',
                'module_type' => 'NARASI',
                'entity_level' => 'IKP_ONLY',
                'id_satker' => self::SERENATA_JAMBIN_SATKER_ID,
                'source_app' => 'e-Laptri Pembinaan JAMBIN',
                'target_app' => 'SERENATA PANEV - Modul Narasi IKP',
                'organization' => 'Jaksa Agung Muda Bidang Pembinaan (JAMBIN)',
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'total_ikp' => count($data),
                'generated_at' => now()->toIso8601String(),
                'payload_sha256' => $payloadSha256,
            ],
            'data' => $data,
        ];
    }

    /**
     * Load strictly canonical IKP nodes (never SK or IKK).
     *
     * @return Collection<int, KinerjaNode>
     */
    private function loadExplicitIkpNodes(int $tahun, int $triwulan, ?string $kodeIkp = null): Collection
    {
        $query = KinerjaNode::query()
            ->where('jenis_node', NodeType::IKP->value)
            ->where('is_active', true)
            ->whereHas('ikp')
            ->with([
                'ikp',
                'units',
                'parents.sp',
                'formulas',
                'targets' => fn ($q) => $q->where('tahun', $tahun),
                'pengukurans' => fn ($q) => $q->where('tahun', $tahun)
                    ->where('triwulan', $triwulan)
                    ->orderByDesc('approved_at')
                    ->orderByDesc('verified_at')
                    ->orderByDesc('submitted_at')
                    ->orderByDesc('updated_at'),
            ]);

        if ($kodeIkp !== null && trim($kodeIkp) !== '') {
            $normalized = trim($kodeIkp);
            $query->where(function ($q) use ($normalized) {
                $q->where('source_key', $normalized)
                    ->orWhere('kode', $normalized)
                    ->orWhereHas('ikp', fn ($ikpQ) => $ikpQ->where('kode_ikp', $normalized));
            });
        }

        return $query->get()->sortBy(function (KinerjaNode $node) {
            $code = $node->ikp?->kode_ikp ?: $node->kode ?: $node->source_key;
            if (preg_match('/(\d+)\.(\d+)/', (string) $code, $matches)) {
                return sprintf('%04d.%04d', (int) $matches[1], (int) $matches[2]);
            }

            return (string) $code;
        })->values();
    }

    private function extractIdentityAndContext(KinerjaNode $node, int $tahun, int $triwulan): array
    {
        $kodeIkp = $node->ikp?->kode_ikp ?: $node->kode ?: $node->source_key;
        $namaIkp = $node->ikp?->nama_ikp ?: $node->nama ?: '-';

        $spParent = $node->parents->first(function ($parent) {
            $type = $parent->jenis_node instanceof NodeType ? $parent->jenis_node->value : (string) $parent->jenis_node;
            return $type === 'SP';
        });

        $kodeSp = $spParent?->sp?->kode_sp ?: ($spParent?->kode ?: null);
        $namaSp = $spParent?->sp?->nama_sp ?: ($spParent?->nama ?: null);

        $units = $node->units->map(fn ($u) => [
            'kode' => $u->kode,
            'nama' => $u->nama,
            'peran' => $u->pivot?->peran ?: 'OWNER',
        ])->values()->all();

        $pengukuran = $node->pengukurans->first();

        return [
            'kode_ikp' => $kodeIkp,
            'nama_ikp' => $namaIkp,
            'kode_sp' => $kodeSp,
            'nama_sp' => $namaSp,
            'unit_pengampu' => $units,
            'pengukuran' => $pengukuran,
        ];
    }

    private function resolveStatusCapaian(?Pengukuran $pengukuran, ?float $capaian, int $triwulan): string
    {
        if ($pengukuran?->status_capaian !== null && $pengukuran->status_capaian !== '') {
            return (string) $pengukuran->status_capaian;
        }

        if ($capaian === null) {
            return 'BELUM_DIINPUT';
        }

        if ($capaian >= 100.0) {
            return 'TERCAPAI';
        }

        return $triwulan < 4 ? 'BELUM_TERCAPAI' : 'TIDAK_TERCAPAI';
    }

    private function resolveSerenataSifatNode(string $satuan, string $tipeKalkulasi, string $arahKinerja): string
    {
        if (strtoupper(trim($arahKinerja)) === 'LOWER_IS_BETTER') {
            return 'UNFAVORABLE';
        }

        $cleanSatuan = strtolower(trim($satuan));
        $cleanTipe = strtoupper(trim($tipeKalkulasi));

        if ($cleanSatuan === '%' || str_contains($cleanSatuan, 'persen') || str_contains($cleanTipe, 'RATIO')) {
            return 'RATIO_PERCENTAGE';
        }

        return 'INDEX_SCORE';
    }

    private function composeSerenataFaktor(?string $analisis, ?string $kendala): ?string
    {
        if ($analisis !== null && $kendala !== null) {
            if ($analisis === $kendala) {
                return $analisis;
            }

            return "Analisis Capaian:\n{$analisis}\n\nKendala:\n{$kendala}";
        }

        return $analisis ?? $kendala;
    }
}
