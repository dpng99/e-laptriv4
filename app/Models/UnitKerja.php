<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitKerja extends Model
{
    use HasFactory;

    protected $table = 'kinerja_units';

    protected $fillable = ['parent_id', 'kode', 'nama', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function nodes(): BelongsToMany
    {
        return $this->belongsToMany(KinerjaNode::class, 'kinerja_unit_nodes', 'unit_kerja_id', 'node_id')
            ->withPivot(['peran', 'bobot'])
            ->withTimestamps();
    }
}
