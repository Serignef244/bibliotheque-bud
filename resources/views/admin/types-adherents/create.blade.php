@extends('layouts.admin')

@section('title', 'Nouveau type d\'adhérent')
@section('page-title', '📋 Nouveau type d\'adhérent')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.types-adherents.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" 
                           id="nom" 
                           name="nom" 
                           value="{{ old('nom') }}"
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duree_jours" class="block text-sm font-medium text-gray-700">Durée d'adhésion (jours)</label>
                    <input type="number" 
                           id="duree_jours" 
                           name="duree_jours" 
                           value="{{ old('duree_jours', 365) }}"
                           min="1"
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('duree_jours')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="max_books" class="block text-sm font-medium text-gray-700">Nombre maximum de livres empruntables</label>
                    <input type="number" 
                           id="max_books" 
                           name="max_books" 
                           value="{{ old('max_books', 5) }}"
                           min="1"
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('max_books')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tarif_penalite" class="block text-sm font-medium text-gray-700">Tarif pénalité (FCFA/jour)</label>
                    <input type="number" 
                           id="tarif_penalite" 
                           name="tarif_penalite" 
                           value="{{ old('tarif_penalite', 100) }}"
                           min="0"
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('tarif_penalite')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.types-adherents.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Créer le type
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
