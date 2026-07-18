<?php

namespace App\Providers;

use App\Repositories\Contracts\CategorieRepositoryInterface;
use App\Repositories\Contracts\ExemplaireRepositoryInterface;
use App\Repositories\Contracts\OuvrageRepositoryInterface;
use App\Repositories\Eloquent\CategorieRepository;
use App\Repositories\Eloquent\ExemplaireRepository;
use App\Repositories\Eloquent\OuvrageRepository;
use App\Repositories\Contracts\AdherentRepositoryInterface;
use App\Repositories\Contracts\TypeAdherentRepositoryInterface;
use App\Repositories\Eloquent\AdherentRepository;
use App\Repositories\Eloquent\TypeAdherentRepository;
use App\Models\Adherent;
use App\Observers\AdherentObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bindings des repositories
        $this->app->bind(CategorieRepositoryInterface::class, CategorieRepository::class);
        $this->app->bind(OuvrageRepositoryInterface::class, OuvrageRepository::class);
        $this->app->bind(ExemplaireRepositoryInterface::class, ExemplaireRepository::class);
        
        $this->app->bind(AdherentRepositoryInterface::class, AdherentRepository::class);
        $this->app->bind(TypeAdherentRepositoryInterface::class, TypeAdherentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Adherent::observe(AdherentObserver::class);
    }
}
