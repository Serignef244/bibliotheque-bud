<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;
    public string $selectedRole = '';

    public function fillCredentials(string $role): void
    {
        $this->selectedRole = $role;
        if ($role === 'admin') {
            $this->form->email = 'admin@bibliotheque.local';
            $this->form->password = 'Admin12345!';
        } elseif ($role === 'biblio') {
            $this->form->email = 'bibliothecaire@bibliotheque.local';
            $this->form->password = 'Biblio12345!';
        } elseif ($role === 'adherent') {
            $this->form->email = 'adherent@bibliotheque.local';
            $this->form->password = 'Adherent12345!';
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full" x-data="{ showPassword: false }">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-xs font-semibold text-primary uppercase tracking-wider mb-3">
            <svg class="w-3.5 h-3.5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            Espace Sécurisé
        </div>
        <h1 class="font-poppins text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Bienvenue sur BiblioSmart</h1>
        <p class="text-sm text-slate-500 mt-1">Connectez-vous pour accéder à vos services de bibliothèque</p>
    </div>

    <!-- Quick Demo Access (Idéal Soutenance) -->
    <div class="mb-6 p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl">
        <div class="flex items-center justify-between mb-2.5">
            <span class="text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Accès Rapide Démo (Jury) :
            </span>
            @if($selectedRole)
                <span class="text-[11px] font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                    ✓ Rempli en 1 clic
                </span>
            @endif
        </div>
        <div class="grid grid-cols-3 gap-2">
            <button type="button" 
                wire:click="fillCredentials('admin')" 
                class="px-2.5 py-2 text-xs font-medium rounded-xl border transition-all text-center flex flex-col items-center gap-1
                {{ $selectedRole === 'admin' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-white hover:bg-slate-100/80 text-slate-700 border-slate-200 hover:border-slate-300' }}">
                <span class="font-semibold">👑 Admin</span>
                <span class="text-[10px] {{ $selectedRole === 'admin' ? 'text-blue-100' : 'text-slate-400' }}">Gestion globale</span>
            </button>

            <button type="button" 
                wire:click="fillCredentials('biblio')" 
                class="px-2.5 py-2 text-xs font-medium rounded-xl border transition-all text-center flex flex-col items-center gap-1
                {{ $selectedRole === 'biblio' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-white hover:bg-slate-100/80 text-slate-700 border-slate-200 hover:border-slate-300' }}">
                <span class="font-semibold">📚 Biblio</span>
                <span class="text-[10px] {{ $selectedRole === 'biblio' ? 'text-blue-100' : 'text-slate-400' }}">Prêts & Retours</span>
            </button>

            <button type="button" 
                wire:click="fillCredentials('adherent')" 
                class="px-2.5 py-2 text-xs font-medium rounded-xl border transition-all text-center flex flex-col items-center gap-1
                {{ $selectedRole === 'adherent' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-white hover:bg-slate-100/80 text-slate-700 border-slate-200 hover:border-slate-300' }}">
                <span class="font-semibold">🎓 Adhérent</span>
                <span class="text-[10px] {{ $selectedRole === 'adherent' ? 'text-blue-100' : 'text-slate-400' }}">Catalogue & Prêts</span>
            </button>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Adresse email</label>
            <div class="relative rounded-xl shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username"
                    class="block w-full rounded-xl border-slate-300 pl-10 pr-4 py-2.5 text-slate-800 placeholder-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 sm:text-sm transition-all"
                    placeholder="nom@exemple.com">
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-1.5 text-xs text-rose-600" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-secondary hover:text-primary transition-colors" href="{{ route('password.request') }}" wire:navigate>
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>
            <div class="relative rounded-xl shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input wire:model="form.password" id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password"
                    class="block w-full rounded-xl border-slate-300 pl-10 pr-11 py-2.5 text-slate-800 placeholder-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 sm:text-sm transition-all"
                    placeholder="••••••••">
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none">
                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-1.5 text-xs text-rose-600" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="flex items-center cursor-pointer select-none">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember"
                    class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary/20 transition">
                <span class="ml-2 text-sm text-slate-600">Garder ma session active</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
            class="w-full inline-flex items-center justify-center px-4 py-3 bg-primary hover:bg-blue-900 text-white font-medium rounded-xl shadow-md shadow-blue-900/10 hover:shadow-lg hover:-translate-y-0.5 active:scale-[0.98] transition-all gap-2 group">
            <span wire:loading.remove wire:target="login">Se connecter à l'espace</span>
            <span wire:loading wire:target="login" class="inline-flex items-center gap-2">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Connexion en cours...
            </span>
            <svg wire:loading.remove wire:target="login" class="w-4 h-4 text-blue-200 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>
    </form>

    <!-- Register Link -->
    <div class="mt-8 pt-6 border-t border-slate-200/80 text-center">
        <p class="text-sm text-slate-600">
            Vous n'avez pas encore d'identifiants ? 
            <a href="{{ route('register') }}" class="font-semibold text-secondary hover:text-primary transition-colors inline-flex items-center gap-1" wire:navigate>
                Créer un compte adhérent
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </p>
    </div>
</div>
