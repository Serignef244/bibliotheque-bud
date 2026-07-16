<?php

namespace App\Models;

use App\Enums\StatutPenalite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penalite extends Model
{
    protected $table = 'penalites';

    protected $fillable = [
        'pret_id',
        'adherent_id',
        'montant',
        'montant_restant',
        'jours_retard',
        'statut',
        'date_paiement',
    ];

    protected $casts = [
        'statut' => StatutPenalite::class,
        'date_paiement' => 'date',
    ];

    public function pret(): BelongsTo
    {
        return $this->belongsTo(Pret::class);
    }

    public function adherent(): BelongsTo
    {
        return $this->belongsTo(Adherent::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    // Accessors
    public function getMontantFormateAttribute()
    {
        return number_format($this->montant, 0, ',', ' ') . ' FCFA';
    }

    public function getRestantFormateAttribute()
    {
        return number_format($this->montant_restant, 0, ',', ' ') . ' FCFA';
    }

    // Vérifications
    public function isPaid(): bool
    {
        return $this->statut === StatutPenalite::PAYE;
    }

    public function isUnpaid(): bool
    {
        return $this->statut === StatutPenalite::IMPAYE;
    }

    public function getSolde(): int
    {
        return $this->montant_restant;
    }
}
