<?php

namespace App\Events;

use App\DTO\ProlongationDTO;
use App\Models\Adherent;
use App\Models\Pret;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PretProlonge
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Pret $pret,
        public readonly Adherent $adherent,
        public readonly ProlongationDTO $prolongationDTO,
    ) {}
}
