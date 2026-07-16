<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Categorie extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'parent_id',
        'ordre',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'ordre'  => 'integer',
    ];

    // ─── Slug automatique ────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Categorie $categorie) {
            if (empty($categorie->slug)) {
                $categorie->slug = Str::slug($categorie->nom);
            }
        });

        static::updating(function (Categorie $categorie) {
            if ($categorie->isDirty('nom') && ! $categorie->isDirty('slug')) {
                $categorie->slug = Str::slug($categorie->nom);
            }
        });
    }

    // ─── Relations ───────────────────────────────────────────────────────────

    /** Catégorie parente */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }

    /** Sous-catégories enfants */
    public function enfants(): HasMany
    {
        return $this->hasMany(Categorie::class, 'parent_id')->orderBy('ordre');
    }

    /** Tous les descendants (récursif) */
    public function descendants(): HasMany
    {
        return $this->enfants()->with('descendants');
    }

    /** Ouvrages rattachés à cette catégorie */
    public function ouvrages(): BelongsToMany
    {
        return $this->belongsToMany(Ouvrage::class, 'ouvrage_categorie', 'categorie_id', 'ouvrage_id')
                    ->withPivot('principale')
                    ->withTimestamps();
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    public function scopeRacines($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdonnes($query)
    {
        return $query->orderBy('ordre')->orderBy('nom');
    }

    // ─── Accesseurs ──────────────────────────────────────────────────────────

    public function getNomCompletAttribute(): string
    {
        return $this->parent
            ? $this->parent->nom . ' › ' . $this->nom
            : $this->nom;
    }

    public function getEstRacineAttribute(): bool
    {
        return is_null($this->parent_id);
    }
}
