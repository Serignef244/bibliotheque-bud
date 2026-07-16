<?php

namespace App\Policies;

use App\Models\Ouvrage;
use App\Models\User;

class OuvragePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function view(User $user, Ouvrage $ouvrage): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function update(User $user, Ouvrage $ouvrage): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function delete(User $user, Ouvrage $ouvrage): bool
    {
        return $user->hasRole('admin');
    }

    public function restore(User $user, Ouvrage $ouvrage): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Ouvrage $ouvrage): bool
    {
        return $user->hasRole('admin');
    }
}
