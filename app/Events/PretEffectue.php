<?php

namespace App\Events;

use App\Models\Adherent;
use App\Models\Exemplaire;
use App\Models\Pret;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PretEffectue
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Pret $pret,
        public readonly Adherent $adherent,
        public readonly Exemplaire $exemplaire,
    ) {}
}
