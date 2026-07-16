<?php

namespace App\Repositories\Eloquent;

use App\Models\HistoriquePret;
use App\Repositories\Interfaces\HistoriquePretRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class HistoriquePretRepository implements HistoriquePretRepositoryInterface
{
    public function all(): Collection
    {
        return HistoriquePret::with(['pret', 'utilisateur'])->get();
    }

    public function find(int $id): ?HistoriquePret
    {
        return HistoriquePret::with(['pret', 'utilisateur'])->find($id);
    }

    public function create(array $data): HistoriquePret
    {
        return HistoriquePret::create($data);
    }

    public function addHistory(int $pretId, string $action, int $userId, array $details = []): HistoriquePret
    {
        return HistoriquePret::create([
            'pret_id' => $pretId,
            'action' => $action,
            'utilisateur_id' => $userId,
            'details' => $details,
        ]);
    }

    public function getByPret(int $pretId): Collection
    {
        return HistoriquePret::with(['utilisateur'])
            ->byPret($pretId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByAction(string $action): Collection
    {
        return HistoriquePret::with(['pret', 'utilisateur'])
            ->byAction($action)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByUtilisateur(int $utilisateurId): Collection
    {
        return HistoriquePret::with(['pret'])
            ->where('utilisateur_id', $utilisateurId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getHistory(?int $pretId = null, ?string $action = null, ?string $recherche = null, int $perPage = 15)
    {
        $query = HistoriquePret::query()->with(['pret', 'utilisateur']);

        if ($pretId) {
            $query->where('pret_id', $pretId);
        }

        if ($action) {
            $query->where('action', $action);
        }

        if ($recherche) {
            $recherche = trim($recherche);
            $query->where(function ($q) use ($recherche) {
                $q->whereHas('pret', function ($sub) use ($recherche) {
                    $sub->where('id', 'like', "%{$recherche}%");
                })->orWhereHas('utilisateur', function ($sub) use ($recherche) {
                    $sub->where('name', 'like', "%{$recherche}%")
                        ->orWhere('email', 'like', "%{$recherche}%");
                })->orWhere('action', 'like', "%{$recherche}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
