<?php

namespace App\Policies;

use App\Models\TypeAdherent;
use App\Models\User;

class TypeAdherentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function view(User $user, TypeAdherent $typeAdherent): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function update(User $user, TypeAdherent $typeAdherent): bool
    {
        return $user->hasAnyRole(['admin', 'bibliothecaire']);
    }

    public function delete(User $user, TypeAdherent $typeAdherent): bool
    {
        return $user->hasRole('admin');
    }
}
