<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

it('renvoie une erreur de validation si l\'adhérent est absent', function () {
    Role::firstOrCreate(['name' => 'admin']);

    $user = User::factory()->create();
    $user->assignRole('admin');

    $response = $this->actingAs($user)->post('/admin/prets', [
        'exemplaire_id' => 1,
        'date_emprunt' => now()->toDateString(),
        'remarques' => 'test',
    ]);

    $response->assertSessionHasErrors('adherent_id');
    $response->assertStatus(302);
});
