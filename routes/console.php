<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Commands pour les adhérents
Schedule::command('adherents:verifier-expirations')->daily();
Schedule::command('adherents:envoyer-rappels 7')->daily();

// Commands pour les prêts
Schedule::command('prets:verifier-retards')->daily();
Schedule::command('prets:envoyer-rappels 3')->daily();
