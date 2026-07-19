<?php

namespace App\Models;

use App\Enums\StatutAdherent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adherent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'type_adherent_id',
        'num_carte',
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'photo',
        'date_naissance',
        'date_inscription',
        'date_expiration',
        'statut',
        'motif_radiation',
    ];

    protected function casts(): array
    {
        return [
            'date_naissance' => 'date',
            'date_inscription' => 'date',
            'date_expiration' => 'date',
            'statut' => StatutAdherent::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function typeAdherent(): BelongsTo
    {
        return $this->belongsTo(TypeAdherent::class);
    }

    public function prets(): HasMany
    {
        return $this->hasMany(Pret::class);
    }

    public function penalites(): HasMany
    {
        return $this->hasMany(Penalite::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo) {
            return null;
        }
        if (str_starts_with($this->photo, 'http')) {
            return $this->photo;
        }
        return asset('storage/' . $this->photo);
    }
}
