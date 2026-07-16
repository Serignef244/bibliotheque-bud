<?php

namespace App\Models;

use App\Enums\StatutExemplaire;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exemplaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'exemplaires';

    protected $fillable = [
        'ouvrage_id',
        'code_barre',
        'cote',
        'statut',
        'date_acquisition',
        'prix_acquisition',
        'fournisseur',
        'notes',
        'etat',
    ];

    protected $casts = [
        'statut'           => StatutExemplaire::class,
        'date_acquisition' => 'date',
        'prix_acquisition' => 'decimal:2',
        'etat'             => 'integer',
    ];

    // ─── Observers (recalcul compteurs) ──────────────────────────────────────

    protected static function booted(): void
    {
        static::saved(function (Exemplaire $exemplaire) {
            $exemplaire->ouvrage->recalculerCompteurs();
        });

        static::deleted(function (Exemplaire $exemplaire) {
            $exemplaire->ouvrage->recalculerCompteurs();
        });
    }

    // ─── Relations ───────────────────────────────────────────────────────────

    public function ouvrage(): BelongsTo
    {
        return $this->belongsTo(Ouvrage::class, 'ouvrage_id');
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeDisponible($query)
    {
        return $query->where('statut', StatutExemplaire::DISPONIBLE->value);
    }

    public function scopeEmprunte($query)
    {
        return $query->where('statut', StatutExemplaire::EMPRUNTE->value);
    }

    public function scopeParCodeBarre($query, string $code)
    {
        return $query->where('code_barre', $code);
    }

    // ─── Accesseurs ──────────────────────────────────────────────────────────

    public function getEtatLabelAttribute(): string
    {
        return match ($this->etat) {
            5 => 'Neuf',
            4 => 'Très bon',
            3 => 'Bon',
            2 => 'Passable',
            1 => 'Mauvais',
            default => 'Inconnu',
        };
    }

    public function getEtatCouleurAttribute(): string
    {
        return match ($this->etat) {
            5, 4 => 'emerald',
            3    => 'amber',
            2    => 'orange',
            1    => 'red',
            default => 'gray',
        };
    }

    public function getEstDisponibleAttribute(): bool
    {
        return $this->statut === StatutExemplaire::DISPONIBLE;
    }
}
