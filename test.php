<?php
$json = file_get_contents('e:/ckmy/e-laptriv4-ready/e-laptriv4/database/data/kinerja_jambin_2025_2029.json');
$data = json_decode($json, true);
$out = [];
foreach($data['activities'] as $a) {
    $out[] = $a['indicator_code'] . ' | ' . $a['indicator_name'] . ' | ' . $a['unit'] . ' | ' . substr(str_replace("\n", ' ', $a['formula']), 0, 100);
}
file_put_contents('e:/ckmy/e-laptriv4-ready/e-laptriv4/scratch.txt', implode(PHP_EOL, $out));
