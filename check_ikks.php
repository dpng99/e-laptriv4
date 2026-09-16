<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$nodes = App\Models\KinerjaNode::where('jenis_node', 'IKK')->where('calculation_type', 'DIRECT_VALUE')->get();

foreach($nodes as $node) {
    $formula = $node->formulas()->where('is_active', true)->orderByDesc('versi')->orderByDesc('id')->first();
    echo $node->source_key . ' - ' . $node->nama . "\n";
    echo 'status_formula: ' . ($formula ? $formula->status_formula : 'NO_FORMULA') . "\n";
    echo 'status() output: ' . app(App\Services\Formula\FormulaResolver::class)->status($node, $formula) . "\n";
    echo "====================\n";
}
