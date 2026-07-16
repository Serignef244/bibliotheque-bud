@extends('layouts.adherent')

@section('title', 'Historique des prêts')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('adherent.prets.index') }}" class="p-2 text-slate-400 hover:text-editorial bg-white hover:bg-slate-50 rounded-full transition-colors border border-slate-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="font-serif text-3xl font-semibold text-slate-900 tracking-tight">Historique de lecture</h1>
                <p class="text-slate-500 mt-1">Tous les livres que vous avez empruntés.</p>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="bg-white rounded-[2rem] p-6 sm:p-10 shadow-sm border border-slate-200/60">
        @if($history->isEmpty())
            <div class="py-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900 mb-1">Aucun historique</h3>
                <p class="text-slate-500 text-sm">Vous n'avez pas encore terminé de prêts.</p>
            </div>
        @else
            <div class="relative border-l-2 border-slate-100 ml-4 space-y-12">
                @foreach($history as $pret)
                    <div class="relative pl-8 sm:pl-12 group">
                        <!-- Point -->
                        <span class="absolute -left-[11px] top-2 h-5 w-5 rounded-full {{ $pret->date_retour_reelle > $pret->date_retour_prevue ? 'bg-amber-500 ring-amber-100' : 'bg-editorial ring-editorial-50' }} ring-8"></span>
                        
                        <div class="flex flex-col sm:flex-row gap-6">
                            <!-- Couverture (petit) -->
                            <div class="w-16 h-24 bg-slate-100 rounded-lg overflow-hidden shadow-sm flex-shrink-0 border border-slate-200/50">
                                @if($pret->exemplaire->ouvrage->image_couverture)
                                    <img src="{{ $pret->exemplaire->ouvrage->image_url }}" alt="{{ $pret->exemplaire->ouvrage->titre }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Infos -->
                            <div class="flex-1">
                                <h3 class="font-serif font-bold text-lg text-slate-900 leading-tight mb-1">
                                    <a href="{{ route('adherent.catalogue.show', $pret->exemplaire->ouvrage->id) }}" class="hover:text-editorial transition-colors">{{ $pret->exemplaire->ouvrage->titre }}</a>
                                </h3>
                                <p class="text-sm text-slate-500 mb-3">{{ $pret->exemplaire->ouvrage->auteurs ?: 'Auteur inconnu' }}</p>
                                
                                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-medium text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Emprunté le {{ $pret->date_emprunt->format('d/m/Y') }}
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Retourné le {{ $pret->date_retour_reelle->format('d/m/Y') }}
                                    </div>
                                    @if($pret->date_retour_reelle > $pret->date_retour_prevue)
                                        <div class="flex items-center gap-1.5 text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Retour en retard
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100">
                {{ $history->links() ?? '' }}
            </div>
        @endif
    </div>
</div>
@endsection
