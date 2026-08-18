<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RunDailyTasks
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Clé unique pour aujourd'hui
        $cacheKey = 'daily_tasks_run_' . date('Y-m-d');

        if (!\Illuminate\Support\Facades\Cache::has($cacheKey)) {
            // Verrouiller immédiatement pour éviter les exécutions multiples concurrentes
            \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->endOfDay());

            try {
                \Illuminate\Support\Facades\Artisan::call('prets:verifier-retards');
                \Illuminate\Support\Facades\Artisan::call('prets:envoyer-rappels', ['jours' => 3]);
                \Illuminate\Support\Facades\Artisan::call('adherents:envoyer-rappels', ['jours' => 7]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Erreur lors des tâches quotidiennes (RunDailyTasks) : " . $e->getMessage());
                // En cas d'erreur, on peut supprimer la clé pour réessayer au prochain hit
                \Illuminate\Support\Facades\Cache::forget($cacheKey);
            }
        }

        return $response;
    }
}
