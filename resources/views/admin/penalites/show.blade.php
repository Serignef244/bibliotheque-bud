@extends('layouts.admin')

@section('title', 'Paiement d\'une pénalité')
@section('page-title', '💰 Détails et Paiement')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.penalites.index') }}" 
           class="text-slate-500 hover:text-slate-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour aux pénalités
        </a>
        @if($penalite->isPaid() || $penalite->statut === \App\Enums\StatutPenalite::PARTIEL)
            <a href="{{ route('admin.penalites.recu', $penalite) }}" target="_blank"
               class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Générer reçu
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Info Adhérent --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide mb-4 border-b border-slate-100 pb-3">👤 Adhérent</h3>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600 font-bold">
                    {{ strtoupper(substr($penalite->adherent->prenom, 0, 1) . substr($penalite->adherent->nom, 0, 1)) }}
                </div>
                <div>
                    <h4 class="font-bold text-slate-900">{{ $penalite->adherent->prenom }} {{ $penalite->adherent->nom }}</h4>
                    <p class="text-sm text-slate-500 font-mono mt-0.5">{{ $penalite->adherent->num_carte }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $penalite->adherent->typeAdherent->nom }}</p>
                </div>
            </div>
            @if(app(\App\Services\PenaliteService::class)->estBloque($penalite->adherent_id))
                <div class="mt-4 bg-red-50 text-red-700 text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Adhérent bloqué pour impayés
                </div>
            @endif
        </div>

        {{-- Info Pénalité --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide mb-4 border-b border-slate-100 pb-3">📋 Détails de la pénalité</h3>
            <ul class="space-y-3 text-sm">
                <li class="flex justify-between">
                    <span class="text-slate-500">Ouvrage :</span>
                    <span class="font-medium text-slate-900">{{ $penalite->pret->exemplaire->ouvrage->titre }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-slate-500">Date retour prévue :</span>
                    <span class="font-medium text-slate-900">{{ $penalite->pret->date_retour_prevue->format('d/m/Y') }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-slate-500">Date retour réelle :</span>
                    <span class="font-medium text-slate-900">{{ $penalite->pret->date_retour_reelle->format('d/m/Y') }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-slate-500">Jours de retard :</span>
                    <span class="font-medium text-red-600">{{ $penalite->jours_retard }} jours</span>
                </li>
                <li class="flex justify-between pt-2 border-t border-slate-100">
                    <span class="text-slate-500">Montant total :</span>
                    <span class="font-bold text-slate-900">{{ $penalite->montant_formate }}</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Section Paiement --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-slate-900">Paiement</h3>
            <span class="inline-flex px-2.5 py-0.5 rounded-xl text-xs font-medium {{ $penalite->statut->color() }}">
                {{ $penalite->statut->label() }}
            </span>
        </div>

        <div class="p-6">
            <div class="mb-6 flex justify-between items-end border-b border-slate-100 pb-6">
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Reste à payer</p>
                    <p class="text-4xl font-bold {{ $penalite->montant_restant > 0 ? 'text-indigo-600' : 'text-emerald-600' }} mt-1">
                        {{ $penalite->restant_formate }}
                    </p>
                </div>
            </div>

            @if($penalite->montant_restant > 0)
                <form action="{{ route('admin.penalites.payer', $penalite) }}" method="POST" class="space-y-4 max-w-sm">
                    @csrf
                    <div>
                        <label for="montant" class="block text-sm font-medium text-slate-700 mb-1">Montant du paiement (FCFA)</label>
                        <div class="relative">
                            <input type="number" name="montant" id="montant" 
                                   value="{{ old('montant', $penalite->montant_restant) }}" 
                                   min="1" max="{{ $penalite->montant_restant }}" required
                                   class="w-full pl-4 pr-12 py-3 bg-white border border-slate-300 rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <span class="text-slate-500 font-medium text-sm">FCFA</span>
                            </div>
                        </div>
                        @error('montant') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="flex-1 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-sm transition-colors flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Enregistrer le paiement
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-6 bg-emerald-50 rounded-xl border border-emerald-100">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-emerald-800 font-semibold">Cette pénalité est entièrement réglée.</p>
                </div>
            @endif
        </div>
        
        {{-- Historique des paiements --}}
        @if($penalite->paiements->count() > 0)
        <div class="border-t border-slate-100">
            <div class="px-6 py-4 bg-slate-50">
                <h4 class="text-sm font-semibold text-slate-900">Historique des paiements</h4>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($penalite->paiements as $paiement)
                <div class="px-6 py-3 flex justify-between items-center text-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-slate-900">Paiement effectué</p>
                            <p class="text-xs text-slate-500">{{ $paiement->date_paiement->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <span class="font-bold text-slate-900">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
