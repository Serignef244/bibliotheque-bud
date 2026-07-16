@extends('layouts.adherent')

@section('title', $ouvrage->titre)

@section('content')
<div class="max-w-5xl mx-auto space-y-12 pb-12">
    
    <!-- Breadcrumb & Back -->
    <nav class="flex items-center gap-2 text-sm text-slate-500 font-medium">
        <a href="{{ route('adherent.catalogue.index') }}" class="hover:text-editorial flex items-center gap-1 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour au catalogue
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-900 truncate">{{ $ouvrage->titre }}</span>
    </nav>

    <!-- Main Book Info -->
    <div class="bg-white rounded-[2rem] p-6 sm:p-10 shadow-sm border border-slate-200/60 flex flex-col md:flex-row gap-10 relative overflow-hidden">
        
        <!-- Decorative background circle -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-editorial-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

        <!-- Cover -->
        <div class="w-full md:w-1/3 lg:w-1/4 flex-shrink-0 z-10">
            <div class="aspect-[2/3] bg-slate-100 rounded-2xl overflow-hidden shadow-lg border border-slate-200/50 relative">
                @if($ouvrage->image_couverture)
                    <img src="{{ $ouvrage->image_url }}" alt="{{ $ouvrage->titre }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                @endif
                
                @php
                    $disponibles = $ouvrage->exemplaires->where('statut', 'disponible')->count();
                    $total = $ouvrage->exemplaires->count();
                @endphp
                <div class="absolute top-4 left-4">
                    @if($disponibles > 0)
                        <span class="bg-emerald-500/90 backdrop-blur text-white text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span> {{ $disponibles }} Disponible(s)
                        </span>
                    @else
                        <span class="bg-amber-500/90 backdrop-blur text-white text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-white"></span> Tous empruntés
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="flex-1 flex flex-col z-10">
            @if($ouvrage->categories->isNotEmpty())
                <div class="flex gap-2 mb-3 flex-wrap">
                    @foreach($ouvrage->categories as $categorie)
                        <span class="text-xs font-bold text-editorial uppercase tracking-wider bg-editorial-50 px-2.5 py-1 rounded-md">{{ $categorie->nom }}</span>
                    @endforeach
                </div>
            @endif

            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-slate-900 leading-tight mb-2">{{ $ouvrage->titre }}</h1>
            <p class="text-lg text-slate-500 font-medium mb-6">de <span class="text-slate-900">{{ $ouvrage->auteurs ?: 'Auteur inconnu' }}</span></p>

            <!-- Quick Specs -->
            <div class="flex flex-wrap gap-6 mb-8 text-sm">
                @if($ouvrage->annee_publication)
                    <div class="flex flex-col gap-1">
                        <span class="text-slate-400 uppercase tracking-wider font-semibold text-[10px]">Année</span>
                        <span class="font-medium text-slate-900">{{ $ouvrage->annee_publication }}</span>
                    </div>
                @endif
                @if($ouvrage->editeur)
                    <div class="flex flex-col gap-1 border-l border-slate-200 pl-6">
                        <span class="text-slate-400 uppercase tracking-wider font-semibold text-[10px]">Éditeur</span>
                        <span class="font-medium text-slate-900">{{ $ouvrage->editeur }}</span>
                    </div>
                @endif
                @if($ouvrage->isbn)
                    <div class="flex flex-col gap-1 border-l border-slate-200 pl-6">
                        <span class="text-slate-400 uppercase tracking-wider font-semibold text-[10px]">ISBN</span>
                        <span class="font-mono text-slate-900">{{ $ouvrage->isbn }}</span>
                    </div>
                @endif
                <div class="flex flex-col gap-1 border-l border-slate-200 pl-6">
                    <span class="text-slate-400 uppercase tracking-wider font-semibold text-[10px]">Collection</span>
                    <span class="font-medium text-slate-900">{{ $total }} exemplaire(s)</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap gap-4 mt-auto">
                <button class="px-8 py-3 bg-editorial hover:bg-editorial-light text-white font-medium rounded-xl transition-colors shadow-sm shadow-editorial/20 flex items-center gap-2" onclick="alert('Fonctionnalité de réservation à venir !')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Réserver un exemplaire
                </button>
                <button class="px-4 py-3 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 font-medium rounded-xl transition-colors flex items-center justify-center shadow-sm" title="Ajouter aux favoris" onclick="alert('Favoris bientôt disponibles')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </button>
                <button class="px-4 py-3 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 font-medium rounded-xl transition-colors flex items-center justify-center shadow-sm" title="Partager">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Layout 2 Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Synopsis -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200/60">
                <h3 class="font-serif text-2xl font-semibold text-slate-900 mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-editorial" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    Résumé
                </h3>
                <div class="prose prose-slate max-w-none prose-p:text-slate-600 prose-p:leading-relaxed">
                    @if($ouvrage->description)
                        {!! nl2br(e($ouvrage->description)) !!}
                    @else
                        <p class="italic text-slate-400">Aucun résumé disponible pour cet ouvrage.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-6">
            <!-- Exemplaires -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/60">
                <h3 class="font-serif text-lg font-semibold text-slate-900 mb-4">État des exemplaires</h3>
                <div class="space-y-3">
                    @forelse($ouvrage->exemplaires as $index => $ex)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-slate-400">#{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="font-mono text-xs text-slate-600">{{ $ex->code_barre }}</span>
                            </div>
                            @if($ex->statut == 'disponible')
                                <span class="text-emerald-600 text-xs font-bold uppercase tracking-wider flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Dispo</span>
                            @else
                                <span class="text-amber-600 text-xs font-bold uppercase tracking-wider flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Prêté</span>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Aucun exemplaire.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations (Similar) -->
    @if($similaires->isNotEmpty())
        <div class="pt-8 border-t border-slate-200">
            <h2 class="font-serif text-2xl font-semibold text-slate-900 mb-6">Dans la même catégorie</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                @foreach($similaires as $livre)
                    <a href="{{ route('adherent.catalogue.show', $livre->id) }}" class="group">
                        <div class="aspect-[2/3] bg-slate-100 rounded-xl overflow-hidden mb-3 relative shadow-sm border border-slate-200/50">
                            @if($livre->image_couverture)
                                <img src="{{ $livre->image_url }}" alt="{{ $livre->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-editorial/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                <span class="px-4 py-2 bg-white text-editorial text-xs font-bold uppercase tracking-wider rounded-full shadow-lg">Voir</span>
                            </div>
                        </div>
                        <h3 class="font-bold text-sm text-slate-900 leading-tight line-clamp-2 group-hover:text-editorial transition-colors">{{ $livre->titre }}</h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $livre->auteurs ?: 'Inconnu' }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
