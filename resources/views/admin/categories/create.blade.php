@extends('layouts.admin')

@section('title', 'Nouvelle catégorie')
@section('header', 'Créer une catégorie')

@section('content')
<div class="max-w-2xl mx-auto">

    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="hover:text-indigo-600 transition-colors">Catégories</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-800 font-medium">Nouvelle catégorie</span>
    </nav>

    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-5">
        @csrf

        @error('general')
        <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">{{ $message }}</div>
        @enderror

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-5">

            <div>
                <label for="nom" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Nom <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nom" name="nom" value="{{ old('nom') }}"
                       placeholder="Ex : Sciences humaines"
                       class="w-full px-4 py-2.5 rounded-xl border @error('nom') border-red-400 bg-red-50 @else border-slate-200 @enderror text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                @error('nom')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="parent_id" class="block text-sm font-medium text-slate-700 mb-1.5">Catégorie parente</label>
                <select id="parent_id" name="parent_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    <option value="">— Aucune (catégorie racine) —</option>
                    @foreach($parentes as $p)
                        <option value="{{ $p['id'] }}" {{ old('parent_id') == $p['id'] ? 'selected' : '' }}>
                            {{ $p['label'] }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                <textarea id="description" name="description" rows="3"
                          placeholder="Description optionnelle de la catégorie…"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition resize-none">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="ordre" class="block text-sm font-medium text-slate-700 mb-1.5">Ordre d'affichage</label>
                    <input type="number" id="ordre" name="ordre" value="{{ old('ordre', 0) }}" min="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div class="flex items-end pb-2.5">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="actif" value="0">
                        <input type="checkbox" name="actif" value="1" id="actif"
                               {{ old('actif', true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-slate-700">Catégorie active</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                Annuler
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Créer la catégorie
            </button>
        </div>
    </form>
</div>
@endsection
