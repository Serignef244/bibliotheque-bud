<?php

namespace App\Policies;

use App\Models\Adherent;
use App\Models\User;

class AdherentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function view(User $user, Adherent $adherent): bool
    {
        // L'adhérent peut voir sa propre fiche
        if ($adherent->user_id === $user->id) {
            return true;
        }

        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function update(User $user, Adherent $adherent): bool
    {
        // L'adhérent peut modifier sa propre fiche (informations basiques)
        if ($adherent->user_id === $user->id) {
            return true;
        }

        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function delete(User $user, Adherent $adherent): bool
    {
        return $user->hasRole('admin');
    }

    public function suspend(User $user, Adherent $adherent): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function generateCard(User $user, Adherent $adherent): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }
}
