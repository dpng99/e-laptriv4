<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportTemplate extends Model
{
    use HasFactory;

    protected $table = 'report_templates';

    protected $fillable = [
        'name',
        'file_path',
        'file_name',
        'file_size',
        'is_active',
        'description',
        'uploaded_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'username');
    }

    public static function getActiveTemplate(): ?self
    {
        return static::where('is_active', true)->latest()->first();
    }
}
