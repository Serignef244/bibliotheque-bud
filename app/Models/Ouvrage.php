<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Ouvrage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ouvrages';

    protected $fillable = [
        'titre',
        'slug',
        'isbn',
        'auteurs',
        'editeur',
        'langue',
        'annee_publication',
        'description',
        'image_couverture',
        'nombre_pages',
        'format',
        'nombre_exemplaires_total',
        'nombre_exemplaires_disponibles',
        'actif',
    ];

    protected $casts = [
        'actif'                           => 'boolean',
        'nombre_pages'                    => 'integer',
        'nombre_exemplaires_total'        => 'integer',
        'nombre_exemplaires_disponibles'  => 'integer',
        'annee_publication'               => 'integer',
    ];

    // ─── Slug automatique ────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Ouvrage $ouvrage) {
            if (empty($ouvrage->slug)) {
                $ouvrage->slug = Str::slug($ouvrage->titre);
            }
        });

        static::updating(function (Ouvrage $ouvrage) {
            if ($ouvrage->isDirty('titre') && ! $ouvrage->isDirty('slug')) {
                $ouvrage->slug = Str::slug($ouvrage->titre);
            }
        });

        // Mise à jour du compteur de disponibilité après modification d'exemplaires
        static::saved(function (Ouvrage $ouvrage) {
            // Synchronisé via le service ou les observers, pas directement ici
        });
    }

    // ─── Relations ───────────────────────────────────────────────────────────

    /** Exemplaires physiques de cet ouvrage */
    public function exemplaires(): HasMany
    {
        return $this->hasMany(Exemplaire::class, 'ouvrage_id');
    }

    /** Exemplaires disponibles */
    public function exemplairesDisponibles(): HasMany
    {
        return $this->hasMany(Exemplaire::class, 'ouvrage_id')
                    ->where('statut', \App\Enums\StatutExemplaire::DISPONIBLE->value);
    }

    /** Catégories de cet ouvrage */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categorie::class, 'ouvrage_categorie', 'ouvrage_id', 'categorie_id')
                    ->withPivot('principale')
                    ->withTimestamps();
    }

    /** Catégorie principale */
    public function categoriePrincipale(): BelongsToMany
    {
        return $this->categories()->wherePivot('principale', true);
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    public function scopeDisponible($query)
    {
        return $query->where('nombre_exemplaires_disponibles', '>', 0);
    }

    public function scopeParCategorie($query, int $categorieId)
    {
        return $query->whereHas('categories', fn ($q) => $q->where('categories.id', $categorieId));
    }

    public function scopeRecherche($query, string $terme)
    {
        return $query->where(function ($q) use ($terme) {
            $q->where('titre', 'like', "%{$terme}%")
              ->orWhere('auteurs', 'like', "%{$terme}%")
              ->orWhere('isbn', 'like', "%{$terme}%")
              ->orWhere('editeur', 'like', "%{$terme}%");
        });
    }

    // ─── Accesseurs ──────────────────────────────────────────────────────────

    public function getAuteursListeAttribute(): array
    {
        if (is_array($this->auteurs)) {
            return $this->auteurs;
        }
        return array_map('trim', explode(',', $this->auteurs ?? ''));
    }

    public function getAuteursPrincipalAttribute(): string
    {
        $liste = $this->auteurs_liste;
        return $liste[0] ?? 'Auteur inconnu';
    }

    public function getEstDisponibleAttribute(): bool
    {
        return $this->nombre_exemplaires_disponibles > 0;
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_couverture) {
            return null;
        }
        if (str_starts_with($this->image_couverture, 'http')) {
            return $this->image_couverture;
        }
        return asset('storage/' . $this->image_couverture);
    }

    /**
     * Recalcule et sauvegarde les compteurs d'exemplaires.
     */
    public function recalculerCompteurs(): void
    {
        $this->nombre_exemplaires_total       = $this->exemplaires()->count();
        $this->nombre_exemplaires_disponibles = $this->exemplairesDisponibles()->count();
        $this->saveQuietly();
    }
}
