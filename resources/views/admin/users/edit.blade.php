@extends('layouts.admin')

@section('header', 'Modifier l\'utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.utilisateurs.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-8 border-b border-slate-200 bg-slate-50 flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-lg border border-blue-200">
                {{ substr($user->name, 0, 2) }}
            </div>
            <div>
                <h2 class="text-2xl font-poppins font-bold text-slate-900">{{ $user->name }}</h2>
                <p class="text-slate-600 mt-1">Modification du profil et des accès</p>
            </div>
        </div>

        <form action="{{ route('admin.utilisateurs.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
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
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Adresse email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>

                <!-- Sécurité -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Sécurité
                    </h3>
                    
                    <p class="text-sm text-slate-500 mb-4 bg-slate-50 p-3 rounded border border-slate-100">Laissez les champs mot de passe vides si vous ne souhaitez pas le modifier.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="password" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <label class="flex items-start gap-3 cursor-pointer group">
                        <div class="flex items-center h-6">
                            <input type="checkbox" name="must_change_password" value="1" class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" {{ old('must_change_password', $user->must_change_password) ? 'checked' : '' }}>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-900 group-hover:text-blue-600 transition-colors">Forcer le changement de mot de passe</p>
                            <p class="text-sm text-slate-500">L'utilisateur devra changer son mot de passe lors de sa prochaine connexion.</p>
                        </div>
                    </label>
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
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="w-5 h-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" {{ in_array($role->name, old('roles', $userRoles)) ? 'checked' : '' }} {{ ($user->id === auth()->id() && $role->name === 'admin') ? 'disabled' : '' }}>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900 group-hover:text-blue-600 transition-colors">
                                        {{ ucfirst($role->name) }}
                                        @if($user->id === auth()->id() && $role->name === 'admin')
                                            <span class="ml-2 text-xs text-red-500 bg-red-50 px-2 py-0.5 rounded border border-red-100">(Impossible de se retirer ce rôle)</span>
                                            <input type="hidden" name="roles[]" value="admin">
                                        @endif
                                    </p>
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
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
