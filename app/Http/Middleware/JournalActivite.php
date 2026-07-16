<?php

namespace App\Http\Middleware;

use App\Models\JournalActivite as JournalActiviteModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JournalActivite
{
    /**
     * @var array<int, string>
     */
    protected array $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->user() && in_array($request->method(), $this->methods, true)) {
            JournalActiviteModel::create([
                'utilisateur_id' => $request->user()->id,
                'action' => $request->method(),
                'route' => $request->path(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'date' => now(),
            ]);
        }

        return $response;
    }
}
