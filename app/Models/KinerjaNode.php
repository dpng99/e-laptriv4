<?php

namespace App\Models;

use App\Enums\NodeType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class KinerjaNode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'jenis_node', 'source_key', 'kode', 'nama', 'satuan', 'calculation_type',
        'formula_key', 'input_enabled', 'measurement_scope', 'tahun_mulai',
        'tahun_selesai', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'jenis_node' => NodeType::class,
            'input_enabled' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function ss(): HasOne { return $this->hasOne(Ss::class, 'node_id'); }
    public function ikss(): HasOne { return $this->hasOne(Ikss::class, 'node_id'); }
    public function sp(): HasOne { return $this->hasOne(Sp::class, 'node_id'); }
    public function ikp(): HasOne { return $this->hasOne(Ikp::class, 'node_id'); }
    public function sk(): HasOne { return $this->hasOne(Sk::class, 'node_id'); }
    public function ikk(): HasOne { return $this->hasOne(Ikk::class, 'node_id'); }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'kinerja_relasi', 'child_node_id', 'parent_node_id')
            ->withPivot(['jenis_relasi', 'dasar_relasi', 'bobot', 'dokumen_kinerja_id', 'halaman_sumber', 'catatan'])
            ->withTimestamps();
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'kinerja_relasi', 'parent_node_id', 'child_node_id')
            ->withPivot(['jenis_relasi', 'dasar_relasi', 'bobot', 'dokumen_kinerja_id', 'halaman_sumber', 'catatan'])
            ->withTimestamps();
    }

    public function childrenByRelation(string $relation): BelongsToMany
    {
        return $this->children()->wherePivot('jenis_relasi', $relation);
    }

    public function formulaChildren(): BelongsToMany
    {
        return $this->childrenByRelation('FORMULA_COMPONENT');
    }

    public function targets(): HasMany { return $this->hasMany(Target::class, 'node_id'); }
    public function pengukurans(): HasMany { return $this->hasMany(Pengukuran::class, 'node_id'); }
    public function formulas(): HasMany { return $this->hasMany(RumusIndikator::class, 'node_id'); }
    public function referensi(): HasMany { return $this->hasMany(ReferensiNode::class, 'node_id'); }

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(UnitKerja::class, 'kinerja_unit_nodes', 'node_id', 'unit_kerja_id')
            ->withPivot(['peran', 'bobot'])
            ->withTimestamps();
    }

    /**
     * Filter only operationally visible nodes:
     * - The node itself must have is_active = true
     * - If the node is an IKK, none of its parent SK nodes may be inactive (is_active = false)
     */
    public function scopeVisibleOperational(Builder $query): Builder
    {
        $table = $query->getModel()->getTable();

        return $query->where("{$table}.is_active", true)
            ->where(function (Builder $q) use ($table) {
                $q->where("{$table}.jenis_node", '!=', 'IKK')
                    ->orWhereNotExists(function ($sub) use ($table) {
                        $sub->selectRaw('1')
                            ->from('kinerja_relasi as kr_vis')
                            ->join('kinerja_nodes as parent_sk_node', 'parent_sk_node.id', '=', 'kr_vis.parent_node_id')
                            ->whereColumn('kr_vis.child_node_id', "{$table}.id")
                            ->where('parent_sk_node.jenis_node', 'SK')
                            ->whereNull('parent_sk_node.deleted_at')
                            ->where('parent_sk_node.is_active', false);
                    });
            });
    }

    public function isEffectivelyVisible(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $type = $this->jenis_node instanceof NodeType ? $this->jenis_node->value : (string) $this->jenis_node;
        if ($type === 'IKK') {
            if ($this->relationLoaded('parents')) {
                $inactiveParentSk = $this->parents->first(function ($parent) {
                    $pType = $parent->jenis_node instanceof NodeType ? $parent->jenis_node->value : (string) $parent->jenis_node;
                    return $pType === 'SK' && !$parent->is_active;
                });

                return $inactiveParentSk === null;
            }

            return !DB::table('kinerja_relasi as kr_vis')
                ->join('kinerja_nodes as parent_sk_node', 'parent_sk_node.id', '=', 'kr_vis.parent_node_id')
                ->where('kr_vis.child_node_id', $this->id)
                ->where('parent_sk_node.jenis_node', 'SK')
                ->whereNull('parent_sk_node.deleted_at')
                ->where('parent_sk_node.is_active', false)
                ->exists();
        }

        return true;
    }
}
