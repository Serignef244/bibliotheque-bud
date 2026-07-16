<?php

namespace App\Policies;

use App\Models\Exemplaire;
use App\Models\User;

class ExemplairePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function view(User $user, Exemplaire $exemplaire): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function update(User $user, Exemplaire $exemplaire): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function delete(User $user, Exemplaire $exemplaire): bool
    {
        return $user->hasRole('admin');
    }
}
