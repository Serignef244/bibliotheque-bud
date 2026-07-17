<?php

use App\Enums\StatutAdherent;
use Carbon\Carbon;

if (! function_exists('formatFCFA')) {
    function formatFCFA(int|float $montant): string
    {
        return number_format($montant, 0, ',', ' ').' '.config('bibliotheque.devise', 'FCFA');
    }
}

if (! function_exists('statutBadge')) {
    function statutBadge(string $statut): string
    {
        $classes = match ($statut) {
            'actif', 'disponible', 'rendu', 'paye' => 'bg-green-100 text-green-800',
            'en_cours' => 'bg-blue-100 text-blue-800',
            'suspendu', 'partiel', 'reparation' => 'bg-yellow-100 text-yellow-800',
            'retard', 'impaye', 'expire' => 'bg-orange-100 text-orange-800',
            'emprunte' => 'bg-indigo-100 text-indigo-800',
            'perdu', 'radie' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };

        $label = StatutAdherent::tryFromValue($statut)?->label()
            ?? \App\Enums\StatutExemplaire::tryFromValue($statut)?->label()
            ?? \App\Enums\StatutPret::tryFromValue($statut)?->label()
            ?? \App\Enums\StatutPenalite::tryFromValue($statut)?->label()
            ?? ucfirst(str_replace('_', ' ', $statut));

        return sprintf(
            '<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium %s">%s</span>',
            $classes,
            e($label)
        );
    }
}

if (! function_exists('genererCodeBarre')) {
    function genererCodeBarre(int|string $id): string
    {
        return 'BS-'.str_pad((string) $id, 8, '0', STR_PAD_LEFT);
    }
}


if (! function_exists('estAdherentActif')) {
    function estAdherentActif(?object $adherent): bool
    {
        if ($adherent === null) {
            return false;
        }

        $statut = $adherent->statut ?? null;

        if ($statut instanceof StatutAdherent) {
            return $statut === StatutAdherent::ACTIF;
        }

        return $statut === StatutAdherent::ACTIF->value;
    }
}

if (! function_exists('calculerDateRetour')) {
    function calculerDateRetour(?object $typeAdherent = null): Carbon
    {
        $duree = config('bibliotheque.duree_pret_defaut', 14);

        if ($typeAdherent !== null && isset($typeAdherent->duree_pret)) {
            $duree = (int) $typeAdherent->duree_pret;
        }

        return Carbon::now()->addDays($duree);
    }
}

if (! function_exists('redirectByRole')) {
    function redirectByRole(?\App\Models\User $user): string
    {
        if ($user === null) {
            return route('home');
        }

        if ($user->hasRole('admin') || $user->hasRole('bibliothecaire')) {
            return route('admin.dashboard');
        }

        if ($user->hasRole('adherent')) {
            return route('adherent.dashboard');
        }

        return route('home');
    }
}
