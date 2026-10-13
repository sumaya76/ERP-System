<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDocument extends Model
{
    protected $fillable = [
        'documentable_type',
        'documentable_id',
        'uploaded_by',
        'category',
        'original_name',
        'storage_path',
        'mime_type',
        'size_bytes',
        'expires_at',
        'notes',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'size_bytes' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
