<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SerenataSyncLog extends Model
{
    protected $table = 'serenata_sync_logs';

    public $timestamps = false;

    protected $fillable = [
        'module_type',
        'direction',
        'status',
        'http_status',
        'tahun',
        'triwulan',
        'ikp_count',
        'payload_hash',
        'ip_address',
        'endpoint',
        'actor',
        'error_message',
        'response_summary',
        'duration_ms',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'http_status' => 'integer',
            'tahun' => 'integer',
            'triwulan' => 'integer',
            'ikp_count' => 'integer',
            'duration_ms' => 'integer',
            'created_at' => 'datetime',
        ];
    }
}
