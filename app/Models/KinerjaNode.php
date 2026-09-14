<?php

namespace App\Models;

use App\Enums\NodeType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
