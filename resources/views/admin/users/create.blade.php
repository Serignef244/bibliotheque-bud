@extends('layouts.admin')

@section('header', 'Nouvel utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.utilisateurs.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50">
            <h2 class="text-2xl font-poppins font-bold text-slate-900">👥 Ajouter un membre du personnel</h2>
            <p class="text-slate-600 mt-2">Créez un nouveau compte pour un bibliothécaire ou un administrateur.</p>
        </div>

        <form action="{{ route('admin.utilisateurs.store') }}" method="POST">
            @csrf
            
            <div class="p-8 space-y-8">
                <!-- Informations personnelles -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informations
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nom complet <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Adresse email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>

                <!-- Sécurité (Automatique) -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Sécurité
                    </h3>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex gap-3 text-sm text-blue-800">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <strong>Mot de passe généré automatiquement</strong><br>
                            Un mot de passe sécurisé sera généré et envoyé à l'utilisateur par email. Il sera forcé de le modifier lors de sa première connexion.
                        </div>
                    </div>
                </section>

                <!-- Rôles -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Rôles & Permissions
                    </h3>
                    
                    <div class="space-y-3">
                        @foreach($roles as $role)
                            <label class="flex items-start gap-3 cursor-pointer group p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors @error('roles') border-red-500 @enderror">
                                <div class="flex items-center h-6">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900 group-hover:text-blue-600 transition-colors">{{ ucfirst($role->name) }}</p>
                                    @if($role->name === 'admin')
                                        <p class="text-xs text-slate-500">Accès total au système, y compris la configuration et la gestion des utilisateurs.</p>
                                    @elseif($role->name === 'bibliothecaire')
                                        <p class="text-xs text-slate-500">Gestion des ouvrages, des prêts, des adhérents et des pénalités.</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                        @error('roles') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </section>
            </div>

            <div class="p-6 border-t border-slate-200 bg-slate-50 flex justify-end gap-3 rounded-b-2xl">
                <a href="{{ route('admin.utilisateurs.index') }}" class="px-5 py-2.5 rounded-lg font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition shadow-sm">Annuler</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
