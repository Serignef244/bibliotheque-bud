@extends('layouts.admin')

@section('title', 'Inscrire un adhérent')
@section('page-title', '👥 Inscrire un nouvel adhérent')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h2 class="text-lg font-semibold text-slate-900">Formulaire d'inscription</h2>
            <p class="text-sm text-slate-500 mt-1">Les champs marqués d'un <span class="text-red-500">*</span> sont obligatoires.</p>
        </div>

        <form method="POST" action="{{ route('admin.adherents.store') }}" enctype="multipart/form-data" class="p-6 space-y-8">
            @csrf

            @if($errors->has('general'))
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <p class="text-sm text-red-600">{{ $errors->first('general') }}</p>
                </div>
            @endif

            {{-- Informations personnelles --}}
            <div>
                <h3 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide mb-4">Informations personnelles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-slate-700 mb-1">Prénom <span class="text-red-500">*</span></label>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required
                               class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                               placeholder="Prénom de l'adhérent">
                        @error('prenom') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="nom" class="block text-sm font-medium text-slate-700 mb-1">Nom <span class="text-red-500">*</span></label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                               class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                               placeholder="Nom de l'adhérent">
                        @error('nom') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                               placeholder="email@example.com">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="telephone" class="block text-sm font-medium text-slate-700 mb-1">Téléphone</label>
                        <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}"
                               class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                               placeholder="+221 77 123 45 67">
                        @error('telephone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="date_naissance" class="block text-sm font-medium text-slate-700 mb-1">Date de naissance</label>
                        <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}"
                               class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        @error('date_naissance') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="type_adherent_id" class="block text-sm font-medium text-slate-700 mb-1">Type d'adhérent <span class="text-red-500">*</span></label>
                        <select name="type_adherent_id" id="type_adherent_id" required
                                class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            <option value="">Sélectionner un type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('type_adherent_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->nom }} ({{ $type->duree_jours }} jours • {{ $type->max_books }} livres max)
                                </option>
                            @endforeach
                        </select>
                        @error('type_adherent_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="adresse" class="block text-sm font-medium text-slate-700 mb-1">Adresse</label>
                        <textarea name="adresse" id="adresse" rows="2"
                                  class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition resize-none"
                                  placeholder="Adresse complète">{{ old('adresse') }}</textarea>
                        @error('adresse') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Photo --}}
            <div>
                <h3 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide mb-4">Photo de profil</h3>
                <div class="flex items-center gap-6">
                    <div id="photo-preview" class="w-24 h-24 bg-slate-50 border-2 border-dashed border-slate-300 rounded-2xl flex items-center justify-center overflow-hidden">
                        <svg class="h-10 w-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <input type="file" name="photo" id="photo" accept="image/*"
                               class="text-sm text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition"
                               onchange="previewPhoto(this)">
                        <p class="text-xs text-slate-500 mt-1">JPG, PNG ou GIF. Max 2 Mo.</p>
                        @error('photo') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.adherents.index') }}"
                   class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition-colors">
                    Annuler
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                    Inscrire l'adhérent
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewPhoto(input) {
    const preview = document.getElementById('photo-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
