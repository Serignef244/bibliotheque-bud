@extends('layouts.admin')

@section('title', $ouvrage->titre)
@section('header', 'Détail de l\'ouvrage')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Fil d'Ariane --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('admin.ouvrages.index') }}" class="hover:text-indigo-600 transition-colors">Ouvrages</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-800 font-medium truncate">{{ $ouvrage->titre }}</span>
    </nav>

    {{-- En-tête ouvrage --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start gap-6">
            {{-- Couverture --}}
            <div class="flex-shrink-0">
                @if($ouvrage->image_couverture)
                    <img src="{{ $ouvrage->image_url }}" alt="{{ $ouvrage->titre }}"
                         class="w-32 h-44 object-cover rounded-xl shadow-md">
                @else
                    <div class="w-32 h-44 bg-gradient-to-br from-indigo-100 via-purple-50 to-indigo-200 rounded-xl shadow-md flex items-center justify-center">
                        <svg class="h-12 w-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Informations --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">{{ $ouvrage->titre }}</h1>
                        <p class="text-slate-500 mt-1">{{ $ouvrage->auteurs }}</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @can('update', $ouvrage)
                        <a href="{{ route('admin.ouvrages.edit', $ouvrage) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </a>
                        @endcan
                    </div>
                </div>

                {{-- Badges catégories --}}
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach($ouvrage->categories as $cat)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $cat->pivot->principale ? 'bg-indigo-100 text-indigo-700 ring-1 ring-indigo-300' : 'bg-slate-100 text-slate-600' }}">
                            @if($cat->pivot->principale)
                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endif
                            {{ $cat->nom }}
                        </span>
                    @endforeach
                </div>

                {{-- Metadata --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-5">
                    @if($ouvrage->editeur)
                    <div>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Éditeur</p>
                        <p class="text-sm text-slate-700 mt-0.5 font-medium">{{ $ouvrage->editeur }}</p>
                    </div>
                    @endif
                    @if($ouvrage->annee_publication)
                    <div>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Année</p>
                        <p class="text-sm text-slate-700 mt-0.5 font-medium">{{ $ouvrage->annee_publication }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Langue</p>
                        <p class="text-sm text-slate-700 mt-0.5 font-medium">{{ $ouvrage->langue }}</p>
                    </div>
                    @if($ouvrage->isbn)
                    <div>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">ISBN</p>
                        <p class="text-sm text-slate-700 mt-0.5 font-medium font-mono">{{ $ouvrage->isbn }}</p>
                    </div>
                    @endif
                    @if($ouvrage->nombre_pages)
                    <div>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Pages</p>
                        <p class="text-sm text-slate-700 mt-0.5 font-medium">{{ number_format($ouvrage->nombre_pages) }}</p>
                    </div>
                    @endif
                    @if($ouvrage->format)
                    <div>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Format</p>
                        <p class="text-sm text-slate-700 mt-0.5 font-medium">{{ $ouvrage->format }}</p>
                    </div>
                    @endif
                </div>

                {{-- Description --}}
                @if($ouvrage->description)
                <p class="text-sm text-slate-600 mt-4 leading-relaxed">{{ $ouvrage->description }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Statistiques des exemplaires --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 text-center">
            <div class="text-3xl font-bold text-slate-800">{{ $ouvrage->nombre_exemplaires_total }}</div>
            <div class="text-sm text-slate-500 mt-1">Exemplaire(s) total</div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-200 p-5 text-center">
            <div class="text-3xl font-bold text-emerald-600">{{ $ouvrage->nombre_exemplaires_disponibles }}</div>
            <div class="text-sm text-slate-500 mt-1">Disponible(s)</div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-amber-200 p-5 text-center">
            <div class="text-3xl font-bold text-amber-600">{{ $ouvrage->nombre_exemplaires_total - $ouvrage->nombre_exemplaires_disponibles }}</div>
            <div class="text-sm text-slate-500 mt-1">Emprunté(s)</div>
        </div>
    </div>

    {{-- Liste des exemplaires --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-semibold text-slate-800">Exemplaires</h2>
            @can('create', \App\Models\Exemplaire::class)
            <a href="{{ route('admin.ouvrages.exemplaires.create', $ouvrage) }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un exemplaire
            </a>
            @endcan
        </div>

        @if($ouvrage->exemplaires->isEmpty())
            <div class="py-10 text-center text-slate-400">
                <p>Aucun exemplaire enregistré pour cet ouvrage.</p>
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wide">
                        <th class="text-left px-6 py-3 font-semibold">Code-barres</th>
                        <th class="text-left px-4 py-3 font-semibold">Cote</th>
                        <th class="text-left px-4 py-3 font-semibold">Statut</th>
                        <th class="text-left px-4 py-3 font-semibold">État</th>
                        <th class="text-left px-4 py-3 font-semibold">Acquisition</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($ouvrage->exemplaires as $ex)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-3 font-mono font-medium text-slate-800">{{ $ex->code_barre }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $ex->cote ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $couleurs = [
                                    'disponible'  => 'bg-emerald-100 text-emerald-700',
                                    'emprunte'    => 'bg-amber-100 text-amber-700',
                                    'perdu'       => 'bg-red-100 text-red-700',
                                    'reparation'  => 'bg-blue-100 text-blue-700',
                                ];
                                $classe = $couleurs[$ex->statut->value] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $classe }}">
                                {{ $ex->statut->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $ex->etat_couleur }}-100 text-{{ $ex->etat_couleur }}-700">
                                {{ $ex->etat_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-500">
                            {{ $ex->date_acquisition?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.exemplaires.show', $ex) }}"
                                   class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                @can('update', $ex)
                                <a href="{{ route('admin.exemplaires.edit', $ex) }}"
                                   class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection
