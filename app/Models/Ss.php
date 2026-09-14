<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ss extends Model
{
    use HasFactory;

    protected $table = 'kinerja_ss';
    protected $primaryKey = 'node_id';
    public $incrementing = false;

    protected $fillable = ['node_id', 'kode_ss', 'nama_ss', 'penanggung_jawab_teks'];

    public function node(): BelongsTo
    {
        return $this->belongsTo(KinerjaNode::class, 'node_id');
    }
}
