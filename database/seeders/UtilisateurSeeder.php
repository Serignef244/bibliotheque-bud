<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@bibliotheque.local'],
            [
                'name' => 'Administrateur BiblioSmart',
                'password' => Hash::make('Admin12345!'),
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['admin']);

        $bibliothecaire = User::updateOrCreate(
            ['email' => 'bibliothecaire@bibliotheque.local'],
            [
                'name' => 'Bibliothécaire BiblioSmart',
                'password' => Hash::make('Biblio12345!'),
                'email_verified_at' => now(),
            ]
        );
        $bibliothecaire->syncRoles(['bibliothecaire']);
    }
}
