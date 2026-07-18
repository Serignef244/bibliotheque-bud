<?php

use App\Models\User;
use App\Models\TypeAdherent;
use App\Mail\WelcomeAdherentMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $telephone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $type_adherent_id = '';

    public function with(): array
    {
        return [
            'typesAdherent' => TypeAdherent::all(),
        ];
    }

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'telephone' => ['nullable', 'string', 'max:20'],
            'type_adherent_id' => ['required', 'exists:type_adherents,id'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Création de l'utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 2. Assignation du rôle (Spatie)
        $user->assignRole('adherent');

        // 3. Extraction Nom et Prénom
        $parts = explode(' ', $validated['name'], 2);
        $prenom = $parts[0];
        $nom = $parts[1] ?? '';

        // 4. Création de l'adhérent
        // num_carte et date_expiration seront gérés par AdherentObserver
        $adherent = $user->adherent()->create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?: null,
            'type_adherent_id' => $validated['type_adherent_id'],
            'statut' => \App\Enums\StatutAdherent::ACTIF,
            'date_inscription' => now(),
        ]);

        // 5. Envoi de l'email de bienvenue
        try {
            Mail::to($adherent->email)->send(new WelcomeAdherentMail($adherent));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur envoi email: " . $e->getMessage());
        }

        // 6. Redirection avec message de succès
        session()->flash('status', 'Compte créé avec succès ! Un email de bienvenue vous a été envoyé à l\'adresse que vous avez fournie.');
        
        $this->redirect(route('login'), navigate: true);
    }
}; ?>

<div class="w-full">
    <div class="text-center mb-8">
        <h1 class="font-poppins text-3xl font-bold text-slate-900 mb-2">Créer mon compte</h1>
        <p class="text-sm text-slate-500">Remplissez les informations ci-dessous pour vous inscrire.</p>
    </div>

    <form wire:submit="register" class="space-y-6">
        
        <!-- Informations personnelles -->
        <div>
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-200">👤 Informations personnelles</h2>
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nom complet</label>
                    <input wire:model="name" id="name" type="text" required autofocus
                        class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-secondary/20 transition-colors bg-slate-50 focus:bg-white px-4 py-3"
                        placeholder="Mamadou Diallo">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Adresse email</label>
                    <input wire:model="email" id="email" type="email" required
                        class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-secondary/20 transition-colors bg-slate-50 focus:bg-white px-4 py-3"
                        placeholder="votre@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <label for="telephone" class="block text-sm font-semibold text-slate-700 mb-2">Téléphone (optionnel)</label>
                    <input wire:model="telephone" id="telephone" type="text"
                        class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-secondary/20 transition-colors bg-slate-50 focus:bg-white px-4 py-3"
                        placeholder="+221 XX XXX XX XX">
                    <x-input-error :messages="$errors->get('telephone')" class="mt-2 text-sm text-red-600" />
                </div>
            </div>
        </div>

        <!-- Profil -->
        <div class="pt-4">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-200">📋 Profil</h2>
            
            <div>
                <label for="type_adherent_id" class="block text-sm font-semibold text-slate-700 mb-2">Type d'adhérent</label>
                <select wire:model="type_adherent_id" id="type_adherent_id" required
                    class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-secondary/20 transition-colors bg-slate-50 focus:bg-white px-4 py-3">
                    <option value="">Sélectionnez un profil...</option>
                    @foreach($typesAdherent as $type)
                        <option value="{{ $type->id }}">{{ $type->nom }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type_adherent_id')" class="mt-2 text-sm text-red-600" />
            </div>
        </div>

        <!-- Sécurité -->
        <div class="pt-4">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 pb-2 border-b border-slate-200">🔑 Sécurité</h2>
            
            <div class="space-y-4">
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Mot de passe</label>
                    <input wire:model="password" id="password" type="password" required
                        class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-secondary/20 transition-colors bg-slate-50 focus:bg-white px-4 py-3"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirmer le mot de passe</label>
                    <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                        class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-secondary/20 transition-colors bg-slate-50 focus:bg-white px-4 py-3"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                </div>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full px-8 py-3.5 bg-secondary hover:bg-blue-500 text-white font-medium rounded-xl transition-all shadow-sm shadow-secondary/20 flex items-center justify-center gap-2 group">
                ✅ S'inscrire
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

    </form>

    <div class="mt-8 pt-6 border-t border-slate-200 text-center">
        <p class="text-sm text-slate-600">
            Déjà inscrit ? 
            <a href="{{ route('login') }}" class="font-semibold text-secondary hover:text-blue-500 transition-colors" wire:navigate>
                🔑 Se connecter
            </a>
        </p>
    </div>
</div>
