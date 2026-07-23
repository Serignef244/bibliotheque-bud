@extends('layouts.admin')

@section('title', 'Détails adhérent')
@section('page-title', '👥 Détails de l\'adhérent')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.adherents.index') }}" 
           class="text-slate-500 hover:text-slate-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour à la liste
        </a>
        <div class="flex gap-2">
            <a href="{{ route('admin.adherents.edit', $adherent) }}" 
               class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-sm transition-colors">
                Modifier
            </a>
            <button onclick="window.open('{{ route('admin.adherents.carte', $adherent) }}', '_blank')"
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold shadow-sm transition-colors">
                📄 Carte PDF
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Photo et infos principales --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 text-center">
                <div class="w-32 h-32 mx-auto mb-4 rounded-xl overflow-hidden bg-slate-100 ring-4 ring-slate-50">
                    @if($adherent->photo)
                        <img src="{{ $adherent->photo_url }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-slate-900">{{ $adherent->prenom }} {{ $adherent->nom }}</h2>
                <p class="text-slate-500 mt-1 font-mono text-sm">{{ $adherent->num_carte }}</p>
                
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <span class="inline-flex px-3 py-1 rounded-xl text-xs font-semibold
                        {{ $adherent->statut === \App\Enums\StatutAdherent::ACTIF ? 'bg-emerald-100 text-emerald-800' : 
                           ($adherent->statut === \App\Enums\StatutAdherent::SUSPENDU ? 'bg-amber-100 text-amber-800' : 
                           ($adherent->statut === \App\Enums\StatutAdherent::EXPIRE ? 'bg-red-100 text-red-800' : 'bg-slate-100 text-slate-800')) }}">
                        {{ $adherent->statut?->label() ?? $adherent->statut }}
                    </span>
                </div>
                
                <div class="mt-6 pt-6 border-t border-slate-100 flex flex-col items-center">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">QR Code Adhérent</p>
                    <div class="p-2 bg-white border border-slate-200 rounded-xl shadow-sm inline-block">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(120)->margin(1)->generate($adherent->num_carte) !!}
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2">Scanner pour l'emprunt</p>
                </div>
            </div>
        </div>

        {{-- Détails --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Informations personnelles --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 border-b border-slate-100 pb-3">Informations personnelles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Email</p>
                        <p class="text-slate-900 mt-1">{{ $adherent->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Téléphone</p>
                        <p class="text-slate-900 mt-1">{{ $adherent->telephone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Date de naissance</p>
                        <p class="text-slate-900 mt-1">{{ $adherent->date_naissance?->format('d/m/Y') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Adresse</p>
                        <p class="text-slate-900 mt-1">{{ $adherent->adresse ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Informations d'adhésion --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 border-b border-slate-100 pb-3">Informations d'adhésion</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Type d'adhérent</p>
                        <p class="text-slate-900 mt-1 font-medium">{{ $adherent->typeAdherent->nom }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Date d'inscription</p>
                        <p class="text-slate-900 mt-1">{{ $adherent->date_inscription->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Date d'expiration</p>
                        <p class="mt-1 font-medium {{ $adherent->date_expiration->isPast() ? 'text-red-600' : 'text-slate-900' }}">
                            {{ $adherent->date_expiration->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Motif de radiation</p>
                        <p class="text-slate-900 mt-1">{{ $adherent->motif_radiation ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            {{-- Actions rapides --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 border-b border-slate-100 pb-3">Actions rapides</h3>
                <div class="flex flex-wrap gap-3">
                    @if($adherent->statut === \App\Enums\StatutAdherent::ACTIF)
                        <form action="{{ route('admin.adherents.suspendre', $adherent) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-4 py-2 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded-lg text-sm font-semibold transition-colors"
                                    onclick="return confirm('Voulez-vous vraiment suspendre cet adhérent ?')">
                                Suspendre
                            </button>
                        </form>
                    @elseif($adherent->statut === \App\Enums\StatutAdherent::SUSPENDU)
                        <form action="{{ route('admin.adherents.reactiver', $adherent) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-4 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-800 rounded-lg text-sm font-semibold transition-colors">
                                Réactiver
                            </button>
                        </form>
                    @endif
                    
                    <form action="{{ route('admin.adherents.radier', $adherent) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-800 rounded-lg text-sm font-semibold transition-colors"
                                onclick="return confirm('Voulez-vous vraiment radier cet adhérent ?')">
                            Radier
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
