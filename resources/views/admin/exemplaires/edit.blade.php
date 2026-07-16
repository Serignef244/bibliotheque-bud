@extends('layouts.admin')

@section('title', 'Modifier l\'exemplaire')
@section('header', 'Modifier l\'exemplaire')

@section('content')
<div class="max-w-2xl mx-auto">

    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('admin.ouvrages.index') }}" class="hover:text-indigo-600 transition-colors">Ouvrages</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.ouvrages.show', $ouvrage) }}" class="hover:text-indigo-600 transition-colors truncate max-w-xs">{{ $ouvrage->titre }}</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="font-mono text-slate-800">{{ $exemplaire->code_barre }}</span>
    </nav>

    <form method="POST" action="{{ route('admin.exemplaires.update', $exemplaire) }}" class="space-y-5">
        @csrf @method('PUT')
        <input type="hidden" name="ouvrage_id" value="{{ $ouvrage->id }}">
        <input type="hidden" name="code_barre" value="{{ $exemplaire->code_barre }}">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-5">

            <div class="p-3 bg-slate-50 rounded-xl text-sm text-slate-600 font-mono">
                Code-barres : <span class="font-bold text-slate-800">{{ $exemplaire->code_barre }}</span>
            </div>

            <div>
                <label for="statut" class="block text-sm font-medium text-slate-700 mb-1.5">Statut</label>
                <select id="statut" name="statut"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    @foreach(\App\Enums\StatutExemplaire::cases() as $statut)
                        <option value="{{ $statut->value }}" {{ old('statut', $exemplaire->statut->value) === $statut->value ? 'selected' : '' }}>
                            {{ $statut->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="cote" class="block text-sm font-medium text-slate-700 mb-1.5">Cote</label>
                    <input type="text" id="cote" name="cote" value="{{ old('cote', $exemplaire->cote) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div>
                    <label for="etat" class="block text-sm font-medium text-slate-700 mb-1.5">État</label>
                    <select id="etat" name="etat"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                        @foreach([5 => 'Neuf', 4 => 'Très bon', 3 => 'Bon', 2 => 'Passable', 1 => 'Mauvais'] as $val => $lab)
                            <option value="{{ $val }}" {{ old('etat', $exemplaire->etat) == $val ? 'selected' : '' }}>{{ $val }} — {{ $lab }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="date_acquisition" class="block text-sm font-medium text-slate-700 mb-1.5">Date d'acquisition</label>
                    <input type="date" id="date_acquisition" name="date_acquisition"
                           value="{{ old('date_acquisition', $exemplaire->date_acquisition?->format('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div>
                    <label for="prix_acquisition" class="block text-sm font-medium text-slate-700 mb-1.5">Prix (FCFA)</label>
                    <input type="number" id="prix_acquisition" name="prix_acquisition"
                           value="{{ old('prix_acquisition', $exemplaire->prix_acquisition) }}" min="0" step="0.01"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
            </div>

            <div>
                <label for="fournisseur" class="block text-sm font-medium text-slate-700 mb-1.5">Fournisseur</label>
                <input type="text" id="fournisseur" name="fournisseur" value="{{ old('fournisseur', $exemplaire->fournisseur) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-slate-700 mb-1.5">Notes</label>
                <textarea id="notes" name="notes" rows="2"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition resize-none">{{ old('notes', $exemplaire->notes) }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.exemplaires.show', $exemplaire) }}"
               class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                Annuler
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
