<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sk extends Model
{
    use HasFactory;

    protected $table = 'kinerja_sk';
    protected $primaryKey = 'node_id';
    public $incrementing = false;

    protected $fillable = ['node_id', 'kode_sk', 'nama_sk', 'penanggung_jawab_teks'];

    public function node(): BelongsTo
    {
        return $this->belongsTo(KinerjaNode::class, 'node_id');
    }
}
