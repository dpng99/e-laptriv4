<?php

namespace Database\Seeders\Concerns;

use App\Enums\NodeType;
use App\Models\KinerjaNode;
use RuntimeException;

trait LoadsKinerjaDataset
{
    private static ?array $cachedDataset = null;
    private static ?array $cachedMap = null;

    protected function dataset(): array
    {
        if (self::$cachedDataset !== null) {
            return self::$cachedDataset;
        }

        $path = database_path('data/kinerja_jambin_2025_2029.json');
        $contents = file_get_contents($path);

        if ($contents === false) {
            throw new RuntimeException("Dataset tidak dapat dibaca: {$path}");
        }

        return self::$cachedDataset = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
    }

    protected function cascadingMap(): array
    {
        return self::$cachedMap ??= require database_path('data/cascading_map.php');
    }

    protected function plainCode(string $type, string $code): string
    {
        return trim((string) preg_replace('/^'.preg_quote($type, '/').'\s+/i', '', trim($code)));
    }

    protected function displayCode(string $type, string $code): string
    {
        return $type.' '.$this->plainCode($type, $code);
    }

    protected function sourceKey(string $type, string $code): string
    {
        return $type.':'.$this->plainCode($type, $code);
    }

    protected function upsertNode(NodeType $type, string $code): KinerjaNode
    {
        return KinerjaNode::query()->updateOrCreate(
            ['source_key' => $this->sourceKey($type->value, $code)],
            [
                'jenis_node' => $type,
                'tahun_mulai' => 2025,
                'tahun_selesai' => 2029,
                'is_active' => true,
            ],
        );
    }

    protected function node(string $type, string $code): KinerjaNode
    {
        return KinerjaNode::query()
            ->where('source_key', $this->sourceKey($type, $code))
            ->firstOrFail();
    }

    protected function targetNumber(mixed $value): ?float
    {
        if ($value === null) {
            return null;
        }

        $raw = trim((string) $value);

        if ($raw === '' || $raw === '-') {
            return null;
        }

        $normalized = str_replace(',', '.', preg_replace('/[%()\s]/', '', $raw));

        return is_numeric($normalized) ? (float) $normalized : null;
    }
}
