@extends('layouts.guest')

@section('title', 'Sécurisez votre compte')

@section('content')
<div class="max-w-2xl mx-auto py-12">
    <div class="bg-white rounded-[2rem] p-8 sm:p-12 shadow-sm border border-slate-200/60 text-center mb-8 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary to-primary-light"></div>
        
        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-xl flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>

        <h1 class="font-poppins text-3xl font-bold text-slate-900 mb-4">Sécurisez votre compte</h1>
        <p class="text-slate-500 leading-relaxed max-w-lg mx-auto">
            Bienvenue ! Pour des raisons de sécurité, vous devez personnaliser votre mot de passe généré automatiquement avant de pouvoir continuer.
        </p>
    </div>

    <form action="{{ route('password.force-change.store') }}" method="POST" class="bg-white rounded-[2rem] p-8 sm:p-10 shadow-sm border border-slate-200/60">
        @csrf

        @if($errors->any())
            <div class="mb-8 p-4 bg-red-50 rounded-xl border border-red-100 flex gap-3 text-red-600">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-sm">
                    <strong class="font-bold">Il y a des erreurs avec votre mot de passe :</strong>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Nouveau mot de passe -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" required 
                    class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-secondary/20 transition-colors bg-slate-50 focus:bg-white px-4 py-3"
                    placeholder="8 caractères minimum, lettres et chiffres">
                <p class="mt-2 text-xs text-slate-500 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Le mot de passe doit contenir au moins 8 caractères.
                </p>
            </div>

            <!-- Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirmer le nouveau mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required 
                    class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring focus:ring-secondary/20 transition-colors bg-slate-50 focus:bg-white px-4 py-3"
                    placeholder="Retapez votre nouveau mot de passe">
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                Me déconnecter pour l'instant
            </a>
            
            <button type="submit" class="px-8 py-3 bg-secondary hover:bg-blue-500 text-white font-medium rounded-xl transition-colors shadow-sm shadow-secondary/20 flex items-center gap-2">
                Enregistrer et continuer
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </form>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>
@endsection
