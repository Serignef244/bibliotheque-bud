@extends('layouts.adherent')

@section('title', 'Tableau de bord — Espace Adhérent')

@section('content')
<div class="space-y-8">
    
    <!-- Hero Banner Adhérent (Anti-Slop & Identité Visuelle) -->
    <div class="rounded-3xl bg-gradient-to-r from-primary via-blue-900 to-secondary text-white p-6 sm:p-8 relative overflow-hidden shadow-xl shadow-blue-950/10">
        <!-- Motifs d'ambiance en arrière-plan -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-24 top-0 w-32 h-32 bg-secondary/20 rounded-full blur-xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-blue-100 uppercase tracking-wider mb-4">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Portail Étudiant & Chercheur
                </div>
                <h1 class="font-poppins text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-white mb-2">
                    Bonjour, {{ $adherent->prenom }} {{ $adherent->nom }} <span class="wave text-2xl sm:text-3xl">👋</span>
                </h1>
                <p class="text-blue-100/90 text-sm sm:text-base leading-relaxed mb-4">
                    Bienvenue dans votre centre de ressources numériques. Consultez vos emprunts en cours, découvrez les nouvelles acquisitions et gérez votre compte en toute autonomie.
                </p>

                <!-- Badges d'identité adhérent -->
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white/15 border border-white/20 font-mono text-white font-medium">
                        <svg class="w-3.5 h-3.5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        N° {{ $adherent->numero_adherent }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-500/20 border border-blue-400/30 text-blue-100 font-medium">
                        Profil : {{ $adherent->typeAdherent->nom ?? 'Adhérent' }}
                    </span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Compte Valide
                    </span>
                </div>
            </div>

            <!-- Actions Rapides -->
            <div class="flex flex-col sm:flex-row lg:flex-col gap-3 shrink-0">
                <a href="{{ route('adherent.profil.carte') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white text-primary hover:bg-blue-50 font-semibold text-xs sm:text-sm shadow-md transition-all active:scale-[0.98]">
                    <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Télécharger ma Carte PDF
                </a>
                <a href="{{ route('adherent.catalogue.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/20 font-medium text-xs sm:text-sm transition-all">
                    <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Rechercher un livre
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Grid (Tokens de Design & Éléments visuels clairs) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        
        <!-- Emprunts en cours -->
        @php
            $countPrets = $pretsEnCours->count();
            $maxQuota = $quota ?: 1;
            $pourcentagePrets = min(100, round(($countPrets / $maxQuota) * 100));
            $retards = $pretsEnCours->filter->estEnRetard()->count();
        @endphp
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow relative overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    @if($retards > 0)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                            {{ $retards }} en retard
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            ✓ À jour
                        </span>
                    @endif
                </div>

                <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Prêts en cours</div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-poppins font-bold text-slate-900">{{ $countPrets }}</span>
                    <span class="text-sm font-medium text-slate-500">/ {{ $quota }} max autorisés</span>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-slate-100 rounded-full h-2 mt-4 overflow-hidden">
                    <div class="h-2 rounded-full transition-all duration-500 {{ $pourcentagePrets >= 100 ? 'bg-amber-500' : 'bg-primary' }}" style="width: {{ $pourcentagePrets }}%"></div>
                </div>
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500">{{ $quota - $countPrets }} emprunt(s) disponible(s)</span>
                <a href="{{ route('adherent.prets.index') }}" class="text-xs font-semibold text-secondary hover:text-primary transition-colors inline-flex items-center gap-1">
                    Mes emprunts &rarr;
                </a>
            </div>
        </div>

        <!-- Pénalités & Amendes -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow relative overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl {{ $totalImpaye > 0 ? 'bg-rose-50 border border-rose-100 text-rose-600' : 'bg-emerald-50 border border-emerald-100 text-emerald-600' }} flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    @if($totalImpaye > 0)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                            Impayé actif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Aucun impayé
                        </span>
                    @endif
                </div>

                <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Situation financière</div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-poppins font-bold {{ $totalImpaye > 0 ? 'text-rose-600' : 'text-slate-900' }}">
                        {{ number_format($totalImpaye, 0, ',', ' ') }}
                    </span>
                    <span class="text-sm font-medium text-slate-500">FCFA</span>
                </div>

                <p class="text-xs text-slate-500 mt-2">
                    @if($totalImpaye > 0)
                        Pénalités calculées suite à des retards de restitution.
                    @else
                        Votre compte est parfaitement en règle.
                    @endif
                </p>
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500">{{ $penalites->count() }} facture(s) en attente</span>
                <a href="{{ route('adherent.penalites.index') }}" class="text-xs font-semibold text-secondary hover:text-primary transition-colors inline-flex items-center gap-1">
                    Détails pénalités &rarr;
                </a>
            </div>
        </div>

        <!-- Validité de l'Adhésion -->
        @php
            $joursRestantsAbo = $adherent->date_expiration ? (int) now()->diffInDays($adherent->date_expiration, false) : null;
        @endphp
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow relative overflow-hidden flex flex-col justify-between sm:col-span-2 lg:col-span-1">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    @if($joursRestantsAbo !== null && $joursRestantsAbo > 0)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Actif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            À renouveler
                        </span>
                    @endif
                </div>

                <div class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">Abonnement bibliothèque</div>
                <div class="text-2xl font-poppins font-bold text-slate-900 leading-tight">
                    {{ $adherent->typeAdherent->nom ?? 'Standard' }}
                </div>

                <p class="text-xs text-slate-500 mt-2">
                    @if($adherent->date_expiration)
                        Expire le <span class="font-medium text-slate-700">{{ $adherent->date_expiration->format('d/m/Y') }}</span>
                        @if($joursRestantsAbo !== null && $joursRestantsAbo > 0)
                            <span class="text-emerald-600 font-semibold">({{ $joursRestantsAbo }} jours restants)</span>
                        @endif
                    @else
                        Durée indéterminée
                    @endif
                </p>
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500">Service du prêt informatisé</span>
                <a href="{{ route('adherent.profil.index') }}" class="text-xs font-semibold text-secondary hover:text-primary transition-colors inline-flex items-center gap-1">
                    Mon profil &rarr;
                </a>
            </div>
        </div>

    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Colonne Principale (Lectures + Recommandations) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Mes Livres en Cours -->
            <section class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="font-poppins text-xl font-bold text-slate-900 tracking-tight">Mes lectures en cours</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Ouvrages actuellement en votre possession</p>
                    </div>
                    <a href="{{ route('adherent.prets.index') }}" class="text-xs sm:text-sm font-semibold text-secondary hover:text-primary transition-colors inline-flex items-center gap-1">
                        Tout voir
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                @if($pretsEnCours->isEmpty())
                    <!-- Empty State Élégant selon le skill frontend-design -->
                    <div class="bg-slate-50 border border-slate-200/70 rounded-2xl p-8 sm:p-10 text-center">
                        <div class="w-14 h-14 bg-blue-100/60 text-secondary rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-1">Aucun emprunt en cours</h3>
                        <p class="text-slate-500 text-xs sm:text-sm mb-6 max-w-md mx-auto">
                            Vous n'avez pas d'ouvrage emprunté en ce moment. Vous pouvez emprunter jusqu'à {{ $quota }} livres simultanément.
                        </p>
                        <a href="{{ route('adherent.catalogue.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-blue-900 text-white font-medium text-xs sm:text-sm rounded-xl transition-all shadow-sm shadow-blue-900/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Explorer le catalogue
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($pretsEnCours->take(4) as $pret)
                            @php
                                $enRetard = $pret->estEnRetard();
                                $joursRestants = (int) now()->diffInDays($pret->date_retour_prevue, false);
                            @endphp
                            <div class="bg-slate-50/70 hover:bg-slate-50 rounded-2xl p-4 border border-slate-200/80 flex gap-4 group hover:shadow-md hover:border-slate-300 transition-all">
                                <!-- Miniature Couverture -->
                                <div class="w-16 h-24 bg-white rounded-xl overflow-hidden flex-shrink-0 relative border border-slate-200 shadow-sm">
                                    @if($pret->exemplaire->ouvrage->image_couverture)
                                        <img src="{{ $pret->exemplaire->ouvrage->image_url }}" alt="Couverture" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-100">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Infos Livre -->
                                <div class="flex-1 flex flex-col justify-between min-w-0">
                                    <div>
                                        <h3 class="font-bold text-sm text-slate-900 leading-snug line-clamp-2 group-hover:text-primary transition-colors">
                                            <a href="{{ route('adherent.prets.show', $pret->id) }}">{{ $pret->exemplaire->ouvrage->titre }}</a>
                                        </h3>
                                        <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $pret->exemplaire->ouvrage->auteurs ?: 'Auteur inconnu' }}</p>
                                    </div>

                                    <div class="mt-2">
                                        @if($enRetard)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-rose-100 text-rose-700">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Retard : {{ abs($joursRestants) }} jour(s)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                Retour : {{ $pret->date_retour_prevue->format('d/m') }} (J-{{ max(0, $joursRestants) }})
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
            
            <!-- Recommandations & Nouveautés -->
            <section class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="font-poppins text-xl font-bold text-slate-900 tracking-tight">Sélection pour vous</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Ouvrages disponibles prêts à être empruntés</p>
                    </div>
                    <a href="{{ route('adherent.catalogue.index') }}" class="text-xs sm:text-sm font-semibold text-secondary hover:text-primary transition-colors inline-flex items-center gap-1">
                        Catalogue complet
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @forelse($recommandations as $livre)
                        <a href="{{ route('adherent.catalogue.show', $livre->id) }}" class="group block cursor-pointer">
                            <div class="aspect-[2/3] bg-slate-100 rounded-2xl overflow-hidden mb-3 relative shadow-sm border border-slate-200/80 group-hover:shadow-md transition-all">
                                @if($livre->image_couverture)
                                    <img src="{{ $livre->image_url }}" alt="{{ $livre->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center p-3 text-center bg-slate-50 text-slate-400">
                                        <svg class="w-8 h-8 mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <span class="text-[10px] font-semibold line-clamp-2 text-slate-600">{{ $livre->titre }}</span>
                                    </div>
                                @endif
                                
                                <div class="absolute top-2 left-2">
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-500/90 text-white text-[10px] font-semibold backdrop-blur-sm shadow-sm">
                                        Disponible
                                    </span>
                                </div>
                            </div>
                            <h3 class="font-bold text-xs sm:text-sm text-slate-900 leading-snug line-clamp-2 group-hover:text-primary transition-colors">
                                {{ $livre->titre }}
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-0.5 truncate">{{ $livre->auteurs ?: 'Auteur non précisé' }}</p>
                        </a>
                    @empty
                        <div class="col-span-4 text-center py-8 text-slate-400 text-xs">
                            Aucune recommandation disponible actuellement.
                        </div>
                    @endforelse
                </div>
            </section>

        </div>

        <!-- Colonne Latérale (Activité & Informations Utiles) -->
        <div class="space-y-6">
            
            <!-- Activité Récente -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-poppins text-lg font-bold text-slate-900">Activité Récente</h3>
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>

                <div class="relative border-l-2 border-slate-100 ml-2.5 space-y-5">
                    <div class="relative pl-5">
                        <span class="absolute -left-[5px] top-1.5 h-2 w-2 rounded-full bg-secondary ring-4 ring-white"></span>
                        <p class="text-xs font-bold text-slate-900">Connexion à votre espace</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Accès validé au portail BiblioSmart.</p>
                        <span class="text-[10px] text-slate-400 font-medium mt-1 inline-block">Aujourd'hui</span>
                    </div>

                    @foreach($pretsEnCours->take(2) as $pret)
                        <div class="relative pl-5">
                            <span class="absolute -left-[5px] top-1.5 h-2 w-2 rounded-full bg-primary ring-4 ring-white"></span>
                            <p class="text-xs font-bold text-slate-900">Emprunt en cours</p>
                            <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1 font-medium">« {{ $pret->exemplaire->ouvrage->titre }} »</p>
                            <span class="text-[10px] text-slate-400 font-medium mt-1 inline-block">{{ $pret->date_emprunt->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('adherent.prets.history') }}" class="block w-full py-2.5 text-center text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-slate-100 rounded-xl transition-colors">
                        Consulter tout l'historique
                    </a>
                </div>
            </div>

            <!-- Widget Carte & Horaires Bibliothèque -->
            <div class="bg-gradient-to-br from-slate-900 to-primary text-white rounded-3xl p-6 shadow-md relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-lg">🏛️</span>
                        <h4 class="font-poppins font-bold text-sm text-white">Horaires d'ouverture</h4>
                    </div>
                    <div class="space-y-2 text-xs text-blue-100/80 mb-5">
                        <div class="flex justify-between border-b border-white/10 pb-1.5">
                            <span>Lundi – Vendredi :</span>
                            <span class="font-semibold text-white">08h00 – 18h00</span>
                        </div>
                        <div class="flex justify-between border-b border-white/10 pb-1.5">
                            <span>Samedi :</span>
                            <span class="font-semibold text-white">09h00 – 13h00</span>
                        </div>
                        <div class="flex justify-between pt-0.5">
                            <span>Dimanche & Fériés :</span>
                            <span class="text-rose-300 font-semibold">Fermé</span>
                        </div>
                    </div>

                    <a href="{{ route('adherent.catalogue.index') }}" class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 text-white text-xs font-semibold border border-white/20 transition-all">
                        <span>Consulter les nouveautés</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

        </div>
        
    </div>
</div>

<style>
    @keyframes wave-animation {
        0% { transform: rotate( 0.0deg) }
        10% { transform: rotate(14.0deg) }
        20% { transform: rotate(-8.0deg) }
        30% { transform: rotate(14.0deg) }
        40% { transform: rotate(-4.0deg) }
        50% { transform: rotate(10.0deg) }
        60% { transform: rotate( 0.0deg) }
        100% { transform: rotate( 0.0deg) }
    }
    .wave {
        display: inline-block;
        animation-name: wave-animation;
        animation-duration: 2.5s;
        animation-iteration-count: infinite;
        transform-origin: 70% 70%;
    }
</style>
@endsection
