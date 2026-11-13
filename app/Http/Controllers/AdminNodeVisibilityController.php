<?php

namespace App\Http\Controllers;

use App\Models\KinerjaNode;
use App\Services\NodeVisibilityService;
use Illuminate\Http\Request;

class AdminNodeVisibilityController extends Controller
{
    public function __construct(
        private readonly NodeVisibilityService $visibilityService,
    ) {}

    public function toggle(Request $request, KinerjaNode $node)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
            'cascade_children' => 'nullable|boolean',
        ]);

        $actor = $request->user()?->username ?? 'admin';
        $result = $this->visibilityService->toggleNode(
            $node,
            (bool) $validated['is_active'],
            (bool) ($validated['cascade_children'] ?? false),
            $actor
        );

        $statusLabel = $result['is_active'] ? 'dimunculkan' : 'disembunyikan';

        return redirect()->back()->with(
            'success',
            "Visibilitas indikator berhasil {$statusLabel} ({$result['updated_count']} item terdampak)."
        );
    }

    public function bulk(Request $request)
    {
        $validated = $request->validate([
            'target_level' => 'required|string|in:SK,IKK,ALL_SK_IKK',
            'is_active' => 'required|boolean',
            'unit_kerja_id' => 'nullable|integer|exists:kinerja_units,id',
        ]);

        $actor = $request->user()?->username ?? 'admin';
        $count = $this->visibilityService->bulkUpdate(
            $validated['target_level'],
            (bool) $validated['is_active'],
            isset($validated['unit_kerja_id']) ? (int) $validated['unit_kerja_id'] : null,
            $actor
        );

        $actionText = $validated['is_active'] ? 'dimunculkan' : 'disembunyikan';
        $levelText = match ($validated['target_level']) {
            'SK' => 'Seluruh SK (beserta IKK di bawahnya)',
            'IKK' => 'Seluruh IKK',
            default => 'Seluruh SK dan IKK',
        };

        return redirect()->back()->with(
            'success',
            "{$levelText} berhasil {$actionText} ({$count} item diperbarui)."
        );
    }
}
