@extends('layouts.adherent')

@section('title', 'Mes Pénalités')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-poppins text-3xl font-semibold text-slate-900 tracking-tight">Mes Pénalités</h1>
            <p class="text-slate-500 mt-1">Gérez vos factures et impayés liés aux retards de restitution.</p>
        </div>
    </div>

    @php
        $totalImpaye = $penalites->where('statut', 'impaye')->sum('montant_restant');
    @endphp

    @if($penalites->isEmpty())
        <div class="bg-white rounded-[2rem] p-12 text-center shadow-sm border border-slate-200/60 border-dashed">
            <div class="w-20 h-20 bg-emerald-50 rounded-xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h2 class="font-poppins text-2xl font-semibold text-slate-900 mb-2">Félicitations !</h2>
            <p class="text-slate-500 mb-0 max-w-md mx-auto">Vous n'avez actuellement aucune pénalité. Merci de respecter les délais de retour de vos emprunts.</p>
        </div>
    @else
        <!-- Summary Card -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-200/60 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-slate-50 rounded-xl blur-2xl opacity-50 pointer-events-none"></div>
            
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Impayé</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-poppins font-bold {{ $totalImpaye > 0 ? 'text-amber-600' : 'text-slate-900' }}">
                        {{ number_format($totalImpaye, 0, ',', ' ') }}
                    </span>
                    <span class="text-slate-500 font-medium">FCFA</span>
                </div>
            </div>

            @if($totalImpaye > 0)
                <div class="bg-amber-50 border border-amber-200 text-amber-800 px-6 py-4 rounded-xl max-w-sm flex gap-3">
                    <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div class="text-sm">
                        <p class="font-bold mb-1">Paiement requis</p>
                        <p>Veuillez vous rapprocher d'un bibliothécaire pour régulariser votre situation financière.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- List -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200/60 overflow-hidden">
            
            <!-- Mobile Cards -->
            <div class="block md:hidden divide-y divide-slate-100">
                @foreach($penalites as $penalite)
                    <div class="p-6 space-y-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ $penalite->created_at->format('d/m/Y') }}</p>
                                <p class="text-base font-bold text-slate-900 leading-tight">
                                    {{ $penalite->pret->exemplaire->ouvrage->titre ?? 'Livre inconnu' }}
                                </p>
                            </div>
                            @if($penalite->statut->value === 'paye')
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex-shrink-0" title="Payé">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                            @elseif($penalite->statut->value === 'partiel')
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex-shrink-0" title="Partiel">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex-shrink-0" title="Impayé">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <div>
                                <p class="text-xs text-slate-500">Retour prévu</p>
                                <p class="text-sm font-medium text-slate-700">{{ $penalite->pret->date_retour_prevue->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-slate-900">{{ number_format($penalite->montant, 0, ',', ' ') }} FCFA</p>
                                @if($penalite->montant_restant > 0 && $penalite->montant_restant < $penalite->montant)
                                    <p class="text-xs font-semibold text-amber-600">Reste : {{ number_format($penalite->montant_restant, 0, ',', ' ') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">Ouvrage</th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Montant</th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-400 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($penalites as $penalite)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-6 text-sm text-slate-500 whitespace-nowrap">
                                    {{ $penalite->created_at->format('d/m/Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-sm font-medium text-slate-900 line-clamp-1">
                                        {{ $penalite->pret->exemplaire->ouvrage->titre ?? 'Livre inconnu' }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Retour prévu : {{ $penalite->pret->date_retour_prevue->format('d/m/Y') }}
                                    </p>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <p class="text-sm font-bold text-slate-900">{{ number_format($penalite->montant, 0, ',', ' ') }} FCFA</p>
                                    @if($penalite->montant_restant > 0 && $penalite->montant_restant < $penalite->montant)
                                        <p class="text-xs text-amber-600">Reste : {{ number_format($penalite->montant_restant, 0, ',', ' ') }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if($penalite->statut->value === 'paye')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600">
                                            <span class="w-1.5 h-1.5 rounded-xl bg-emerald-500"></span> Payé
                                        </span>
                                    @elseif($penalite->statut->value === 'partiel')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-600">
                                            <span class="w-1.5 h-1.5 rounded-xl bg-blue-500"></span> Partiel
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-amber-50 text-amber-600">
                                            <span class="w-1.5 h-1.5 rounded-xl bg-amber-500"></span> Impayé
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
