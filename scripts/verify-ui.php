<?php

$root = dirname(__DIR__);
$baseline = json_decode(file_get_contents($root.'/tests/fixtures/ui-source-hashes.json'), true, flags: JSON_THROW_ON_ERROR);
$errors = [];
foreach ($baseline['files'] as $file => $expected) {
    $content = is_file($root.'/'.$file) ? file_get_contents($root.'/'.$file) : null;
    if ($content === null || sha1('blob '.strlen($content)."\0".$content) !== $expected) $errors[] = $file;
}
if ($errors) { fwrite(STDERR, 'UI baseline changed: '.implode(', ', $errors).PHP_EOL); exit(1); }
echo 'UI source unchanged: '.count($baseline['files']).' files match '.$baseline['source_commit'].PHP_EOL;
