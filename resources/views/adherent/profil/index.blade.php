@extends('layouts.adherent')

@section('title', 'Mon Profil')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="font-poppins text-3xl font-semibold text-slate-900 tracking-tight">Mon Profil</h1>
            <p class="text-slate-500 mt-1">Vos informations personnelles et votre carte d'adhérent.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Col: Card -->
        <div class="space-y-6">
            <!-- Digital Card -->
            <div class="bg-gradient-to-br from-primary to-slate-900 rounded-[2rem] p-8 shadow-xl text-white relative overflow-hidden group">
                <!-- Abstract BG -->
                <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-xl blur-2xl"></div>
                <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-blue-500/20 rounded-xl blur-2xl"></div>

                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-12">
                        <div>
                            <span class="font-poppins font-bold text-2xl tracking-tight">Biblio<span class="text-white/70">Num</span></span>
                            <p class="text-[10px] font-semibold tracking-widest text-white/50 uppercase mt-1">Carte d'Adhérent</p>
                        </div>
                        <svg class="w-10 h-10 text-white/20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                    </div>

                    <div class="space-y-1">
                        <p class="font-poppins text-xl font-medium tracking-wide">{{ auth()->user()->name }}</p>
                        <p class="font-mono text-sm text-white/80 tracking-widest">{{ $adherent->num_carte }}</p>
                    </div>

                    <div class="mt-8 flex items-end justify-between">
                        <div>
                            <p class="text-[10px] text-white/50 uppercase tracking-widest mb-1">Type</p>
                            <p class="font-semibold text-sm">{{ $adherent->typeAdherent->nom ?? 'Standard' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-white/50 uppercase tracking-widest mb-1">Expire le</p>
                            <p class="font-semibold text-sm">{{ $adherent->date_expiration ? $adherent->date_expiration->format('m/y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Download Button -->
            <a href="{{ route('adherent.profil.carte') }}" class="w-full py-3.5 bg-white border border-slate-200 hover:border-primary text-slate-700 hover:text-primary text-sm font-medium rounded-2xl shadow-sm transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Télécharger la carte
            </a>
        </div>

        <!-- Right Col: Infos -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200/60 overflow-hidden">
                <div class="p-8 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="font-poppins text-xl font-semibold text-slate-900">Informations personnelles</h2>
                    <button class="text-primary hover:text-primary-light text-sm font-medium" onclick="alert('La modification de profil sera bientôt disponible !')">Modifier</button>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nom</p>
                            <p class="font-medium text-slate-900">{{ $adherent->nom }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Prénom</p>
                            <p class="font-medium text-slate-900">{{ $adherent->prenom }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Email</p>
                            <p class="font-medium text-slate-900">{{ auth()->user()->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Téléphone</p>
                            <p class="font-medium text-slate-900">{{ $adherent->telephone ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Adresse</p>
                            <p class="font-medium text-slate-900">{{ $adherent->adresse ?? 'Non renseignée' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 p-8 border-t border-slate-100">
                    <h3 class="font-medium text-slate-900 mb-4">Statistiques du compte</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-xl border border-slate-200/50">
                            <span class="block text-2xl font-poppins font-bold text-slate-900 mb-1">{{ $adherent->prets()->count() }}</span>
                            <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Livres empruntés</span>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200/50">
                            <span class="block text-2xl font-poppins font-bold text-slate-900 mb-1">{{ $adherent->penalites()->count() }}</span>
                            <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pénalités reçues</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
