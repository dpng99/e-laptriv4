<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Services\PengukuranService;

$service = app(PengukuranService::class);

// Test DIRECT_VALUE
$node1 = KinerjaNode::where('source_key', 'IKK:10.9.1')->first();
if ($node1) {
    echo "Testing IKK:10.9.1...\n";
    $unit1 = $node1->units()->first();
    if ($unit1) {
        $row1 = ['realisasi' => '12.5'];
        $meas1 = $service->storeMeasurement($node1, $unit1->id, 2025, 1, $row1);
        echo "Realisasi tersimpan: " . $meas1->realisasi . "\n";
        echo "Input_keys: " . json_encode($meas1->inputs()->pluck('nilai', 'input_key')) . "\n";
    }
}

// Test RATIO
$node2 = KinerjaNode::where('source_key', 'IKK:4.1.1')->first();
if ($node2) {
    echo "\nTesting IKK:4.1.1...\n";
    $unit2 = $node2->units()->first();
    if ($unit2) {
        $row2 = ['pembilang' => '90', 'penyebut' => '100'];
        $meas2 = $service->storeMeasurement($node2, $unit2->id, 2025, 1, $row2);
        echo "Realisasi tersimpan: " . $meas2->realisasi . "\n";
        echo "Input_keys: " . json_encode($meas2->inputs()->pluck('nilai', 'input_key')) . "\n";
    }
}
