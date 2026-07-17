@extends('layouts.adherent')

@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-10">
    
    <!-- Welcome Section -->
    <section>
        <div class="flex items-center gap-4 mb-2">
            <h1 class="font-poppins text-3xl sm:text-4xl font-semibold tracking-tight text-slate-900">
                Bonjour, {{ $adherent->prenom }} <span class="wave text-2xl">👋</span>
            </h1>
        </div>
        <p class="text-slate-500 text-lg">Heureux de vous retrouver dans votre bibliothèque numérique.</p>
    </section>

    <!-- Stats Grid -->
    <section class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
        <!-- Emprunts -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/60 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/></svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Prêts en cours</p>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-poppins font-bold text-slate-900">{{ $pretsEnCours->count() }}</span>
                <span class="text-slate-500 font-medium">/ {{ $quota }}</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-sm text-slate-500">
                    @php $retards = $pretsEnCours->filter->estEnRetard()->count(); @endphp
                    @if($retards > 0)
                        <span class="text-red-600 font-medium">{{ $retards }} en retard</span>
                    @else
                        Tout est à jour
                    @endif
                </span>
                <a href="{{ route('adherent.prets.index') }}" class="text-sm font-medium text-primary hover:text-primary-light transition-colors">Gérer &rarr;</a>
            </div>
        </div>

        <!-- Pénalités -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/60 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-amber-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Pénalités</p>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-poppins font-bold {{ $totalImpaye > 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                    {{ number_format($totalImpaye, 0, ',', ' ') }}
                </span>
                <span class="text-slate-500 font-medium">FCFA</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-sm {{ $totalImpaye > 0 ? 'text-amber-600 font-medium' : 'text-slate-500' }}">
                    {{ $penalites->count() }} facture(s)
                </span>
                <a href="{{ route('adherent.penalites.index') }}" class="text-sm font-medium text-primary hover:text-primary-light transition-colors">Détails &rarr;</a>
            </div>
        </div>

        <!-- Validité -->
        <div class="col-span-2 md:col-span-1 bg-white rounded-3xl p-6 shadow-sm border border-slate-200/60 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Mon Abonnement</p>
            <div class="flex flex-col justify-center h-[40px]">
                <span class="text-2xl font-poppins font-bold text-slate-900">{{ $adherent->typeAdherent->nom }}</span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-sm text-slate-500">
                    Valable jusqu'au {{ $adherent->date_expiration ? $adherent->date_expiration->format('d/m/Y') : 'N/A' }}
                </span>
            </div>
        </div>
    </section>

    <!-- Content Split -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Column -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Mes Livres -->
            <section>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-poppins text-2xl font-semibold text-slate-900">Mes lectures en cours</h2>
                    <a href="{{ route('adherent.prets.index') }}" class="text-sm font-medium text-slate-500 hover:text-primary transition-colors">Tout voir</a>
                </div>
                
                @if($pretsEnCours->isEmpty())
                    <div class="bg-white/50 border border-slate-200/60 border-dashed rounded-3xl p-10 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900 mb-1">Aucun livre en cours</h3>
                        <p class="text-slate-500 text-sm mb-6">Vous n'avez pas encore emprunté d'ouvrage. Explorez notre catalogue pour trouver votre prochaine lecture.</p>
                        <a href="{{ route('adherent.catalogue.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-secondary hover:bg-blue-500 text-white font-medium rounded-xl transition-colors shadow-sm shadow-secondary/20">
                            Explorer le catalogue
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($pretsEnCours->take(4) as $pret)
                            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/60 flex gap-4 group hover:shadow-md transition-shadow">
                                <div class="w-16 h-24 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0 relative">
                                    @if($pret->exemplaire->ouvrage->image_couverture)
                                        <img src="{{ $pret->exemplaire->ouvrage->image_url }}" alt="Couverture" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </div>
                                    @endif
                                    @if($pret->estEnRetard())
                                        <div class="absolute bottom-0 inset-x-0 bg-red-600 text-white text-[10px] font-bold uppercase text-center py-0.5">En retard</div>
                                    @endif
                                </div>
                                <div class="flex-1 flex flex-col justify-center">
                                    <h3 class="font-bold text-slate-900 leading-tight mb-1 line-clamp-2 group-hover:text-primary transition-colors">
                                        <a href="{{ route('adherent.prets.show', $pret->id) }}">{{ $pret->exemplaire->ouvrage->titre }}</a>
                                    </h3>
                                    <p class="text-xs text-slate-500 mb-2">{{ $pret->exemplaire->ouvrage->auteurs ?: 'Auteur inconnu' }}</p>
                                    <div class="text-xs font-medium px-2 py-1 bg-slate-50 rounded-md w-max text-slate-600">
                                        Retour le {{ $pret->date_retour_prevue->format('d/m') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
            
            <!-- Recommendations -->
            <section>
                <h2 class="font-poppins text-2xl font-semibold text-slate-900 mb-4">Recommandés pour vous</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($recommandations as $livre)
                        <div class="group cursor-pointer">
                            <div class="aspect-[2/3] bg-slate-100 rounded-xl overflow-hidden mb-3 relative shadow-sm border border-slate-200/50">
                                @if($livre->image_couverture)
                                    <img src="{{ $livre->image_url }}" alt="{{ $livre->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                @endif
                                <!-- Overlay de hover -->
                                <div class="absolute inset-0 bg-secondary/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                    <span class="px-4 py-2 bg-white text-primary text-xs font-bold uppercase tracking-wider rounded-xl shadow-lg">Voir le livre</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-sm text-slate-900 leading-tight line-clamp-2 group-hover:text-primary transition-colors">{{ $livre->titre }}</h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $livre->auteurs ?: 'Inconnu' }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>

        <!-- Sidebar Activity -->
        <div class="space-y-8">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/60 sticky top-28">
                <h3 class="font-poppins text-xl font-semibold text-slate-900 mb-6">Activité récente</h3>
                <div class="relative border-l-2 border-slate-100 ml-3 space-y-6">
                    <!-- Fake timeline for visual purpose, actual notifications will replace this -->
                    <div class="relative pl-6">
                        <span class="absolute -left-[9px] top-1 h-4 w-4 rounded-xl bg-secondary ring-4 ring-white"></span>
                        <p class="text-sm font-semibold text-slate-900">Bienvenue sur votre espace</p>
                        <p class="text-xs text-slate-500 mt-1">Vous venez de vous connecter à la nouvelle version de la bibliothèque numérique.</p>
                        <p class="text-[10px] text-slate-400 font-medium uppercase mt-2">Aujourd'hui</p>
                    </div>
                    @foreach($pretsEnCours->take(2) as $pret)
                        <div class="relative pl-6">
                            <span class="absolute -left-[9px] top-1 h-4 w-4 rounded-xl bg-slate-200 ring-4 ring-white"></span>
                            <p class="text-sm font-semibold text-slate-900">Emprunt enregistré</p>
                            <p class="text-xs text-slate-500 mt-1">Vous avez emprunté <span class="font-medium">"{{ $pret->exemplaire->ouvrage->titre }}"</span>.</p>
                            <p class="text-[10px] text-slate-400 font-medium uppercase mt-2">{{ $pret->date_emprunt->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <a href="{{ route('adherent.notifications.index') }}" class="block w-full py-2.5 text-center text-sm font-medium text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 rounded-xl transition-colors">
                        Toutes les notifications
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</div>

<style>
    @keyframes wave-animation {
        0% { transform: rotate( 0.0deg) }
        10% { transform: rotate(14.0deg) }  /* The following five values can be played with to make the waving more or less extreme */
        20% { transform: rotate(-8.0deg) }
        30% { transform: rotate(14.0deg) }
        40% { transform: rotate(-4.0deg) }
        50% { transform: rotate(10.0deg) }
        60% { transform: rotate( 0.0deg) }  /* Reset for the last half to pause */
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
