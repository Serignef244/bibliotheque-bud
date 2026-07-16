<?php

namespace App\Policies;

use App\Models\Pret;
use App\Models\User;

class PretPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'bibliothecaire', 'adherent']);
    }

    public function view(User $user, Pret $pret): bool
    {
        if ($user->hasRole(['admin', 'bibliothecaire'])) {
            return true;
        }

        if ($user->hasRole('adherent') && $user->adherent?->id === $pret->adherent_id) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'bibliothecaire']);
    }

    public function update(User $user, Pret $pret): bool
    {
        return $user->hasRole(['admin', 'bibliothecaire']);
    }

    public function delete(User $user, Pret $pret): bool
    {
        return $user->hasRole('admin');
    }

    public function return(User $user, Pret $pret): bool
    {
        return $user->hasRole(['admin', 'bibliothecaire']);
    }

    public function prolonger(User $user, Pret $pret): bool
    {
        if ($user->hasRole(['admin', 'bibliothecaire'])) {
            return true;
        }

        if ($user->hasRole('adherent') && $user->adherent?->id === $pret->adherent_id) {
            return true;
        }

        return false;
    }

    public function viewHistory(User $user, Pret $pret): bool
    {
        if ($user->hasRole(['admin', 'bibliothecaire'])) {
            return true;
        }

        if ($user->hasRole('adherent') && $user->adherent?->id === $pret->adherent_id) {
            return true;
        }

        return false;
    }
}
