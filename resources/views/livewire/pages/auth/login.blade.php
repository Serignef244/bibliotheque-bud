<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

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

<div class="w-full">
    <div class="text-center mb-8">
        <h1 class="font-serif text-3xl font-bold text-slate-900 mb-2">Bon retour</h1>
        <p class="text-sm text-slate-500">Connectez-vous pour accéder à votre espace.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Adresse email</label>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username"
                class="w-full rounded-xl border-slate-200 focus:border-editorial focus:ring focus:ring-editorial/20 transition-colors bg-slate-50 focus:bg-white px-4 py-3"
                placeholder="votre@email.com">
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-sm font-semibold text-slate-700">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-editorial hover:text-editorial-light transition-colors" href="{{ route('password.request') }}" wire:navigate>
                        Oublié ?
                    </a>
                @endif
            </div>
            
            <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full rounded-xl border-slate-200 focus:border-editorial focus:ring focus:ring-editorial/20 transition-colors bg-slate-50 focus:bg-white px-4 py-3"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model="form.remember" id="remember" type="checkbox" name="remember"
                class="rounded border-slate-300 text-editorial focus:ring-editorial/20 w-4 h-4 bg-slate-50">
            <label for="remember" class="ms-2 text-sm font-medium text-slate-600 cursor-pointer">
                Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="w-full px-8 py-3.5 bg-editorial hover:bg-editorial-light text-white font-medium rounded-xl transition-all shadow-sm shadow-editorial/20 flex items-center justify-center gap-2 group">
            Me connecter
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>
    </form>
</div>
