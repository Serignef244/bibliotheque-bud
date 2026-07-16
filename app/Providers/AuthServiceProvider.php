<?php

namespace App\Providers;

use App\Models\Categorie;
use App\Models\Exemplaire;
use App\Policies\CategoriePolicy;
use App\Policies\ExemplairePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Categorie::class, CategoriePolicy::class);
        Gate::policy(Exemplaire::class, ExemplairePolicy::class);
    }
}
