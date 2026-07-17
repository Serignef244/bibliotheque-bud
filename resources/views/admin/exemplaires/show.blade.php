@extends('layouts.admin')

@section('title', 'Exemplaire ' . $exemplaire->code_barre)
@section('header', 'Détail de l\'exemplaire')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('admin.ouvrages.index') }}" class="hover:text-indigo-600 transition-colors">Ouvrages</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.ouvrages.show', $ouvrage) }}" class="hover:text-indigo-600 transition-colors truncate max-w-xs">{{ $ouvrage->titre }}</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="font-mono text-slate-800">{{ $exemplaire->code_barre }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900 font-mono">{{ $exemplaire->code_barre }}</h1>
                <p class="text-slate-500 text-sm mt-1">{{ $ouvrage->titre }}</p>
            </div>
            <div class="flex items-center gap-2">
                @php
                    $couleurs = [
                        'disponible'  => 'bg-emerald-100 text-emerald-700',
                        'emprunte'    => 'bg-amber-100 text-amber-700',
                        'perdu'       => 'bg-red-100 text-red-700',
                        'reparation'  => 'bg-blue-100 text-blue-700',
                    ];
                @endphp
                <span class="px-3 py-1.5 rounded-xl text-sm font-semibold {{ $couleurs[$exemplaire->statut->value] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ $exemplaire->statut->label() }}
                </span>
                @can('update', $exemplaire)
                <a href="{{ route('admin.exemplaires.edit', $exemplaire) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                    Modifier
                </a>
                @endcan
            </div>
        </div>

        <dl class="grid grid-cols-2 sm:grid-cols-3 gap-5 mt-6">
            <div>
                <dt class="text-xs text-slate-400 uppercase tracking-wide font-semibold">Cote</dt>
                <dd class="text-sm text-slate-700 font-medium mt-0.5">{{ $exemplaire->cote ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-400 uppercase tracking-wide font-semibold">État</dt>
                <dd class="mt-0.5">
                    <span class="inline-flex px-2.5 py-1 rounded-xl text-xs font-medium bg-{{ $exemplaire->etat_couleur }}-100 text-{{ $exemplaire->etat_couleur }}-700">
                        {{ $exemplaire->etat_label }} ({{ $exemplaire->etat }}/5)
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-xs text-slate-400 uppercase tracking-wide font-semibold">Date d'acquisition</dt>
                <dd class="text-sm text-slate-700 font-medium mt-0.5">
                    {{ $exemplaire->date_acquisition?->format('d/m/Y') ?? '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-xs text-slate-400 uppercase tracking-wide font-semibold">Prix</dt>
                <dd class="text-sm text-slate-700 font-medium mt-0.5">
                    {{ $exemplaire->prix_acquisition ? number_format($exemplaire->prix_acquisition, 0, ',', ' ') . ' FCFA' : '—' }}
                </dd>
            </div>
            <div>
                <dt class="text-xs text-slate-400 uppercase tracking-wide font-semibold">Fournisseur</dt>
                <dd class="text-sm text-slate-700 font-medium mt-0.5">{{ $exemplaire->fournisseur ?? '—' }}</dd>
            </div>
            @if($exemplaire->notes)
            <div class="col-span-2 sm:col-span-3">
                <dt class="text-xs text-slate-400 uppercase tracking-wide font-semibold">Notes</dt>
                <dd class="text-sm text-slate-600 mt-0.5">{{ $exemplaire->notes }}</dd>
            </div>
            @endif
        </dl>
    </div>

    {{-- Code-barres SVG --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-base font-semibold text-slate-800 mb-4">Code-barres</h2>
        <div class="flex justify-center p-4 bg-white rounded-xl border border-slate-100">
            {!! $svgCodeBarre !!}
        </div>
        <p class="text-xs text-slate-400 text-center mt-3">Code-barres Code128 généré pour l'étiquette physique</p>
    </div>

</div>
@endsection
