<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->must_change_password) {
            $currentRouteName = $request->route() ? $request->route()->getName() : null;
            if (!in_array($currentRouteName, ['adherent.password.force-change', 'adherent.password.force-change.store', 'logout'])) {
                return redirect()->route('adherent.password.force-change');
            }
        }
        return $next($request);
    }
}
