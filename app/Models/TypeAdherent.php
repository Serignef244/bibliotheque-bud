<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeAdherent extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'duree_jours',
        'max_books',
        'tarif_penalite',
        'description',
    ];

    public function adherents(): HasMany
    {
        return $this->hasMany(Adherent::class);
    }
}
