<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $fillable = [
        'penalite_id',
        'adherent_id',
        'montant',
        'date_paiement',
    ];

    protected $casts = [
        'date_paiement' => 'date',
    ];

    public function penalite(): BelongsTo
    {
        return $this->belongsTo(Penalite::class);
    }

    public function adherent(): BelongsTo
    {
        return $this->belongsTo(Adherent::class);
    }
}
