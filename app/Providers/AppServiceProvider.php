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
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

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
        Mail::extend('brevo', function (array $config = []) {
            return (new BrevoTransportFactory())->create(
                new Dsn('brevo+api', 'default', $config['key'] ?? env('BREVO_API_KEY'))
            );
        });
        Adherent::observe(AdherentObserver::class);
    }
}
