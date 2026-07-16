<?php

namespace App\Observers;

use App\Models\Adherent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdherentObserver
{
    /**
     * Handle the Adherent "creating" event.
     */
    public function creating(Adherent $adherent): void
    {
        // Numéro de carte auto-généré : ADH-YYYY-XXXXX
        if (empty($adherent->num_carte)) {
            $year = now()->format('Y');
            $lastAdherent = Adherent::where('num_carte', 'like', "ADH-{$year}-%")->orderBy('num_carte', 'desc')->first();
            $nextSequence = $lastAdherent ? intval(substr($lastAdherent->num_carte, -5)) + 1 : 1;
            $adherent->num_carte = sprintf('ADH-%s-%05d', $year, $nextSequence);
        }

        // Calcul de la date d'expiration
        if (empty($adherent->date_expiration) && $adherent->type_adherent_id) {
            $type = $adherent->typeAdherent;
            if ($type) {
                $adherent->date_expiration = $adherent->date_inscription->addDays($type->duree_jours);
            }
        }
    }

    /**
     * Handle the Adherent "created" event.
     */
    public function created(Adherent $adherent): void
    {
        // Création du compte utilisateur si aucun n'est lié
        if (empty($adherent->user_id)) {
            $user = User::create([
                'name' => $adherent->prenom . ' ' . $adherent->nom,
                'email' => $adherent->email,
                'password' => Hash::make(Str::random(12)), // Mot de passe aléatoire, l'utilisateur devra réinitialiser ou utiliser le lien
            ]);

            $user->assignRole('adherent');

            $adherent->user_id = $user->id;
            $adherent->saveQuietly(); // Pour ne pas re-déclencher l'observer
        }
    }

    /**
     * Handle the Adherent "updated" event.
     */
    public function updated(Adherent $adherent): void
    {
        // Si l'email, le nom ou le prénom changent, on peut mettre à jour le compte User
        if ($adherent->user_id && ($adherent->wasChanged('email') || $adherent->wasChanged('nom') || $adherent->wasChanged('prenom'))) {
            $adherent->user->update([
                'name' => $adherent->prenom . ' ' . $adherent->nom,
                'email' => $adherent->email,
            ]);
        }
    }

    /**
     * Handle the Adherent "deleted" event.
     */
    public function deleted(Adherent $adherent): void
    {
        //
    }

    /**
     * Handle the Adherent "restored" event.
     */
    public function restored(Adherent $adherent): void
    {
        //
    }

    /**
     * Handle the Adherent "force deleted" event.
     */
    public function forceDeleted(Adherent $adherent): void
    {
        // Optionnel: on peut aussi supprimer l'utilisateur associé s'il n'est rattaché à rien d'autre
        if ($adherent->user_id) {
            $adherent->user->delete();
        }
    }
}
