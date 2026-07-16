<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pret extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'adherent_id',
        'exemplaire_id',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour_reelle',
        'prolonge',
        'statut',
        'remarques',
    ];

    protected $casts = [
        'date_emprunt' => 'datetime',
        'date_retour_prevue' => 'date',
        'date_retour_reelle' => 'date',
        'prolonge' => 'boolean',
    ];

    public function adherent(): BelongsTo
    {
        return $this->belongsTo(Adherent::class);
    }

    public function exemplaire(): BelongsTo
    {
        return $this->belongsTo(Exemplaire::class);
    }

    public function historiques(): HasMany
    {
        return $this->hasMany(HistoriquePret::class);
    }

    public function penalite()
    {
        return $this->hasOne(Penalite::class);
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeEnRetard($query)
    {
        return $query->where('statut', 'retard')
            ->orWhere(function ($q) {
                $q->where('statut', 'en_cours')
                    ->where('date_retour_prevue', '<', now());
            });
    }

    public function scopeRendu($query)
    {
        return $query->where('statut', 'rendu');
    }

    public function estEnRetard(): bool
    {
        return $this->date_retour_prevue->isPast() && $this->statut !== 'rendu';
    }

    public function joursDeRetard(): int
    {
        if (!$this->estEnRetard()) {
            return 0;
        }
        return now()->diffInDays($this->date_retour_prevue);
    }

    public function peutEtreProlonge(): bool
    {
        return !$this->prolonge && $this->statut === 'en_cours' && !$this->estEnRetard();
    }
}
