<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriquePret extends Model
{
    protected $fillable = [
        'pret_id',
        'action',
        'utilisateur_id',
        'details',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function pret(): BelongsTo
    {
        return $this->belongsTo(Pret::class);
    }

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByPret($query, int $pretId)
    {
        return $query->where('pret_id', $pretId);
    }
}
