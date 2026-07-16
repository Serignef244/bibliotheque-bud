<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ISBNService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ISBNController extends Controller
{
    public function __construct(
        private readonly ISBNService $isbnService
    ) {}

    /**
     * Recherche un ouvrage par ISBN.
     */
    public function search(Request $request): JsonResponse
    {
        // On s'assure que l'utilisateur a le droit de créer un ouvrage
        Gate::authorize('create', \App\Models\Ouvrage::class);

        $isbn = $request->query('isbn');

        if (!$isbn) {
            return response()->json(['error' => 'ISBN manquant.'], 400);
        }

        try {
            // Passe l'IP pour le rate limiting basique du service
            $data = $this->isbnService->search($isbn, $request->ip());

            if ($data) {
                return response()->json($data);
            }

            return response()->json(['error' => 'Aucun ouvrage trouvé pour cet ISBN.'], 404);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 429);
        }
    }
}
