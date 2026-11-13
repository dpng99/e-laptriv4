<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\UnitKerja;
use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ReviewDataController;
use App\Http\Controllers\AdminRumusController;
use App\Http\Controllers\InputDataController;

echo "=== VERIFIKASI INTEGRITAS DATABASE & FRONTEND DATA PIPELINE ===\n\n";

$passCount = 0;
$failCount = 0;

function assertCheck($name, $condition, $details = '') {
    global $passCount, $failCount;
    if ($condition) {
        echo " [PASS] $name\n";
        if ($details) echo "        -> $details\n";
        $passCount++;
    } else {
        echo " [FAIL] $name\n";
        if ($details) echo "        -> $details\n";
        $failCount++;
    }
}

// 1. Check Operator ro.ren on Dashboard (2025 TW1)
$roRenUser = User::where('username', 'ro.ren')->first();
auth()->setUser($roRenUser);

$dashController = app(DashboardController::class);
$req2025 = Request::create('/dashboard', 'GET', ['tahun' => 2025, 'triwulan' => 1]);
$req2025->setUserResolver(fn() => $roRenUser);
$res2025 = $dashController->index($req2025);
$props2025 = $res2025->toResponse($req2025)->getOriginalContent()['page']['props'];

assertCheck(
    "Operator ro.ren Dashboard 2025 TW1 returns unitName and year",
    $props2025['unitName'] === 'Biro Perencanaan' && $props2025['currentTahun'] === 2025 && $props2025['currentTriwulan'] === 1,
    "Unit: {$props2025['unitName']}, Tahun: {$props2025['currentTahun']}, TW: {$props2025['currentTriwulan']}"
);

assertCheck(
    "Operator ro.ren Dashboard 2025 TW1 has populated IKKs and measurements",
    $props2025['ikkTerisi'] > 0 && $props2025['totalIkk'] > 0 && $props2025['stats']['terisi'] > 0,
    "Total IKK: {$props2025['totalIkk']}, Terisi: {$props2025['ikkTerisi']}, Rata Capaian: {$props2025['rataCapaian']}%"
);

assertCheck(
    "Operator ro.ren Dashboard 2025 TW1 SK performance calculated",
    count($props2025['skPerformance']) > 0 && $props2025['skPerformance'][0]['terisi'] > 0,
    "Jumlah SK: " . count($props2025['skPerformance']) . ", SK pertama: " . ($props2025['skPerformance'][0]['sk_nama'] ?? '') . " rata capaian: " . ($props2025['skPerformance'][0]['rata_capaian'] ?? 0)
);

// 2. Check Operator ro.ren on Dashboard (2026 TW1)
$req2026 = Request::create('/dashboard', 'GET', ['tahun' => 2026, 'triwulan' => 1]);
$req2026->setUserResolver(fn() => $roRenUser);
$res2026 = $dashController->index($req2026);
$props2026 = $res2026->toResponse($req2026)->getOriginalContent()['page']['props'];

assertCheck(
    "Operator ro.ren Dashboard 2026 TW1 has 0 IKK terisi (clean slate for operator manual entry)",
    $props2026['ikkTerisi'] === 0 && $props2026['stats']['belum_diisi'] === $props2026['totalIkk'],
    "Total IKK: {$props2026['totalIkk']}, Terisi: {$props2026['ikkTerisi']}, Belum Diisi: {$props2026['stats']['belum_diisi']}"
);

// 3. Check InputDataController for 2026 TW1
$inputController = app(InputDataController::class);
$resInput2026 = $inputController->index($req2026);
$propsInput2026 = $resInput2026->toResponse($req2026)->getOriginalContent()['page']['props'];

assertCheck(
    "Operator ro.ren Input Data 2026 TW1 loads schema and indicators",
    count($propsInput2026['ikks']) > 0,
    "Jumlah IKK siap input: " . count($propsInput2026['ikks'])
);

// 4. Check Admin jambin on AdminDashboard (2025 TW1)
$adminUser = User::where('username', 'admin.jambin')->first();
auth()->setUser($adminUser);

$adminDashController = app(AdminDashboardController::class);
$adminReq2025 = Request::create('/admin/dashboard', 'GET', ['tahun' => 2025, 'triwulan' => 1]);
$adminReq2025->setUserResolver(fn() => $adminUser);
$adminRes2025 = $adminDashController->index($adminReq2025);
$adminProps2025 = $adminRes2025->toResponse($adminReq2025)->getOriginalContent()['page']['props'];

assertCheck(
    "Admin Dashboard 2025 TW1 aggregates all indicators and tracks 20 strategic IKPs",
    count($adminProps2025['statusList']) > 100 && $adminProps2025['stats']['total_indikator'] === 20 && $adminProps2025['stats']['tercapai'] > 0,
    "DataGrid All Nodes: " . count($adminProps2025['statusList']) . ", Strategic IKP Total: {$adminProps2025['stats']['total_indikator']}, Tercapai: {$adminProps2025['stats']['tercapai']}, Belum: {$adminProps2025['stats']['belum_tercapai']}"
);

$monitoringUnits = array_column($adminProps2025['unitMonitoring'], 'unit_id');
assertCheck(
    "Admin Dashboard unit monitoring only includes 9 operational bureaus (excludes JAMBIN unit 1)",
    !in_array(1, $monitoringUnits) && count($adminProps2025['unitMonitoring']) === 9,
    "Jumlah unit dipantau: " . count($adminProps2025['unitMonitoring']) . " (Biro/Pusat operasional)"
);

// 5. Check ReviewDataController
$reviewController = app(ReviewDataController::class);
$reviewReq = Request::create('/review-data', 'GET', ['tahun' => 2025, 'triwulan' => 1]);
$reviewReq->setUserResolver(fn() => $adminUser);
$reviewRes = $reviewController->index($reviewReq);
$reviewProps = $reviewRes->toResponse($reviewReq)->getOriginalContent()['page']['props'];

$spWithCapaian = collect($reviewProps['data'])->where('tipe_indikator', 'SP')->whereNotNull('capaian_terhadap_target')->count();
assertCheck(
    "ReviewDataController calculates SP achievements from child IKPs",
    $spWithCapaian > 0,
    "Jumlah SP dengan capaian terhitung: $spWithCapaian dari " . collect($reviewProps['data'])->where('tipe_indikator', 'SP')->count() . ", Avg Capaian SP: {$reviewProps['summary']['avgCapaianSp']}%"
);

// Check detail show
$firstIkp = KinerjaNode::where('jenis_node', 'IKP')->first();
$reviewShowRes = $reviewController->show($firstIkp->id, $reviewReq);
$reviewShowProps = $reviewShowRes->toResponse($reviewReq)->getOriginalContent()['page']['props'];

assertCheck(
    "ReviewDataController::show returns dynamic formula and reference",
    $reviewShowProps['indikator']['tipe_formula'] !== 'AGGREGATE / DIRECT',
    "Kode: {$firstIkp->kode}, Formula: {$reviewShowProps['indikator']['tipe_formula']}, Sumber: {$reviewShowProps['indikator']['sumber_data']}"
);

// 6. Check AdminRumusController
$rumusController = app(AdminRumusController::class);
$rumusReq = Request::create('/admin/rumus', 'GET');
$rumusReq->setUserResolver(fn() => $adminUser);
$rumusRes = $rumusController->index();
$rumusProps = $rumusRes->toResponse($rumusReq)->getOriginalContent()['page']['props'];

$firstRumusRow = $rumusProps['formulas'][0] ?? [];
assertCheck(
    "AdminRumusController returns both 'level' and 'tipe_indikator'",
    isset($firstRumusRow['level']) && isset($firstRumusRow['tipe_indikator']),
    "Kode: " . ($firstRumusRow['kode_indikator'] ?? '') . ", Level: " . ($firstRumusRow['level'] ?? '') . ", Tipe: " . ($firstRumusRow['tipe_indikator'] ?? '')
);

echo "\n=== RINGKASAN VERIFIKASI ===\n";
echo "Total Berhasil: $passCount\n";
echo "Total Gagal: $failCount\n";

if ($failCount === 0) {
    echo "\n>>> SELURUH DATA DATABASE & FRONTEND TERHUBUNG DENGAN SEMPURNA! <<<\n";
} else {
    echo "\n>>> MASIH ADA DATA YANG BELUM SESUAI <<<\n";
}
