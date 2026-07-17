@extends('layouts.adherent')

@section('title', 'Mes Emprunts')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="font-poppins text-3xl font-semibold text-slate-900 tracking-tight">Mes emprunts en cours</h1>
            <p class="text-slate-500 mt-1">Gérez vos lectures actuelles et prolongez vos prêts si besoin.</p>
        </div>
        <a href="{{ route('adherent.prets.history') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-primary bg-white border border-slate-200 px-4 py-2 rounded-xl transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Voir l'historique
        </a>
    </div>

    @if($prets->isEmpty())
        <div class="bg-white rounded-[2rem] p-12 text-center shadow-sm border border-slate-200/60 border-dashed">
            <div class="w-20 h-20 bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <h2 class="font-poppins text-2xl font-semibold text-slate-900 mb-2">Vous n'avez aucun prêt en cours</h2>
            <p class="text-slate-500 mb-8 max-w-md mx-auto">Votre bibliothèque est vide. Explorez notre catalogue pour trouver de nouvelles lectures passionnantes.</p>
            <a href="{{ route('adherent.catalogue.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-secondary hover:bg-blue-500 text-white font-medium rounded-xl transition-colors shadow-sm shadow-secondary/20">
                Parcourir le catalogue
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($prets as $pret)
                @php
                    $joursRestants = max(0, round(now()->diffInDays($pret->date_retour_prevue, false)));
                    $totalJours = max(1, $pret->date_emprunt->diffInDays($pret->date_retour_prevue));
                    $joursPasses = $totalJours - $joursRestants;
                    $pourcentage = min(100, max(0, ($joursPasses / $totalJours) * 100));
                    $enRetard = $pret->estEnRetard();
                @endphp
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border {{ $enRetard ? 'border-red-200 bg-red-50/30' : 'border-slate-200/60' }} flex flex-col sm:flex-row gap-6 relative overflow-hidden group">
                    
                    <!-- Couverture -->
                    <div class="w-24 sm:w-32 aspect-[2/3] bg-slate-100 rounded-xl overflow-hidden shadow-sm flex-shrink-0 relative border border-slate-200/50">
                        @if($pret->exemplaire->ouvrage->image_couverture)
                            <img src="{{ $pret->exemplaire->ouvrage->image_url }}" alt="{{ $pret->exemplaire->ouvrage->titre }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                        @endif
                        
                        @if($enRetard)
                            <div class="absolute bottom-0 inset-x-0 bg-red-600/90 backdrop-blur text-white text-[10px] font-bold uppercase tracking-wider text-center py-1">En retard</div>
                        @endif
                    </div>

                    <!-- Infos -->
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h3 class="font-poppins font-bold text-xl text-slate-900 leading-tight">
                                    <a href="{{ route('adherent.catalogue.show', $pret->exemplaire->ouvrage->id) }}" class="hover:text-primary transition-colors">{{ $pret->exemplaire->ouvrage->titre }}</a>
                                </h3>
                            </div>
                            <p class="text-sm text-slate-500 mb-4">{{ $pret->exemplaire->ouvrage->auteurs ?: 'Auteur inconnu' }}</p>

                            <div class="flex flex-col gap-3">
                                <!-- Progress -->
                                <div>
                                    <div class="flex items-center justify-between text-xs font-semibold mb-1.5 uppercase tracking-wider">
                                        <span class="{{ $enRetard ? 'text-red-600' : 'text-slate-500' }}">
                                            {{ $enRetard ? 'Retard de ' . abs($joursRestants) . ' jour(s)' : $joursRestants . ' jour(s) restant(s)' }}
                                        </span>
                                        <span class="text-slate-400">{{ $pret->date_retour_prevue->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="h-2 w-full bg-slate-100 rounded-xl overflow-hidden">
                                        <div class="h-full rounded-xl {{ $enRetard ? 'bg-red-500 w-full' : ($pourcentage > 80 ? 'bg-amber-500' : 'bg-secondary') }}" style="width: {{ $enRetard ? '100%' : $pourcentage . '%' }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 flex items-center gap-3">
                            @if(!$enRetard && !$pret->date_retour_reelle)
                                <form action="{{ route('adherent.prets.prolonger', $pret->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-white border border-slate-200 hover:border-primary text-slate-700 hover:text-primary text-sm font-medium rounded-xl shadow-sm transition-all text-center flex items-center justify-center gap-2" onclick="return confirm('Voulez-vous vraiment prolonger ce prêt ?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="hidden sm:inline">Prolonger</span>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('adherent.catalogue.show', $pret->exemplaire->ouvrage->id) }}" class="{{ $enRetard ? 'w-full flex-1' : 'flex-none sm:flex-1' }} px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 text-sm font-medium rounded-xl transition-colors text-center flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span class="hidden sm:inline">Détails</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
