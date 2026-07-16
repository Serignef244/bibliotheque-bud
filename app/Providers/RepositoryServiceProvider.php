<?php

namespace App\Providers;

use App\Repositories\Eloquent\AdherentRepository;
use App\Repositories\Eloquent\ExemplaireRepository;
use App\Repositories\Eloquent\HistoriquePretRepository;
use App\Repositories\Eloquent\OuvrageRepository;
use App\Repositories\Eloquent\PretRepository;
use App\Repositories\Eloquent\TypeAdherentRepository;
use App\Repositories\Interfaces\AdherentRepositoryInterface;
use App\Repositories\Interfaces\ExemplaireRepositoryInterface;
use App\Repositories\Interfaces\HistoriquePretRepositoryInterface;
use App\Repositories\Interfaces\OuvrageRepositoryInterface;
use App\Repositories\Interfaces\PretRepositoryInterface;
use App\Repositories\Interfaces\TypeAdherentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AdherentRepositoryInterface::class, AdherentRepository::class);
        $this->app->bind(ExemplaireRepositoryInterface::class, ExemplaireRepository::class);
        $this->app->bind(HistoriquePretRepositoryInterface::class, HistoriquePretRepository::class);
        $this->app->bind(OuvrageRepositoryInterface::class, OuvrageRepository::class);
        $this->app->bind(PretRepositoryInterface::class, PretRepository::class);
        $this->app->bind(TypeAdherentRepositoryInterface::class, TypeAdherentRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
