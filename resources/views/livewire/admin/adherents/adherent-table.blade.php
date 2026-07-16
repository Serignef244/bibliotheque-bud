<div class="space-y-6">
    {{-- Barre de filtres --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Recherche --}}
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Recherche</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="recherche"
                           placeholder="Nom, prénom, email, n° de carte…"
                           class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>
            </div>

            {{-- Statut --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Statut</label>
                <select wire:model.live="statut"
                        class="w-full py-2.5 px-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    <option value="">Tous</option>
                    @foreach($statuts as $s)
                        <option value="{{ $s['value'] }}">{{ $s['label'] }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Type</label>
                <select wire:model.live="type_adherent_id"
                        class="w-full py-2.5 px-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    <option value="">Tous</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-4">
            <button wire:click="$set('recherche', '')" wire:click.prevent="$set('statut', '')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition-colors">
                Réinitialiser
            </button>

            <div class="ml-auto flex gap-3">
                <a href="{{ route('admin.types-adherents.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors border border-slate-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Types
                </a>
                <a href="{{ route('admin.adherents.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Nouvel adhérent
                </a>
            </div>
        </div>
    </div>

    {{-- Loading state --}}
    <div wire:loading class="flex justify-center py-8">
        <div class="flex items-center gap-3 text-indigo-600">
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-medium">Chargement…</span>
        </div>
    </div>

    {{-- Résultats --}}
    <div wire:loading.remove class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <p class="text-sm text-slate-500">
                <span class="font-semibold text-slate-700">{{ $adherents->total() }}</span> adhérent{{ $adherents->total() > 1 ? 's' : '' }} trouvé{{ $adherents->total() > 1 ? 's' : '' }}
            </p>
        </div>

        @if($adherents->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <p class="text-slate-700 font-medium">Aucun adhérent trouvé</p>
                <p class="text-slate-500 text-sm mt-1">Modifiez vos filtres ou inscrivez un premier adhérent.</p>
                <a href="{{ route('admin.adherents.create') }}"
                   class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-all">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Inscrire un adhérent
                </a>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($adherents as $adherent)
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors group">
                    {{-- Photo --}}
                    <div class="flex-shrink-0">
                        @if($adherent->photo)
                            <img src="{{ asset('storage/' . $adherent->photo) }}" alt="{{ $adherent->prenom }}"
                                 class="w-10 h-10 rounded-full object-cover ring-2 ring-white">
                        @else
                            <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-600 font-bold text-sm">
                                {{ strtoupper(substr($adherent->prenom, 0, 1) . substr($adherent->nom, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Infos --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-slate-900 truncate">{{ $adherent->prenom }} {{ $adherent->nom }}</h3>
                            @php
                                $statutColor = match($adherent->statut) {
                                    \App\Enums\StatutAdherent::ACTIF => 'bg-emerald-100 text-emerald-800',
                                    \App\Enums\StatutAdherent::SUSPENDU => 'bg-amber-100 text-amber-800',
                                    \App\Enums\StatutAdherent::EXPIRE => 'bg-red-100 text-red-800',
                                    \App\Enums\StatutAdherent::RADIE => 'bg-slate-100 text-slate-800',
                                };
                            @endphp
                            <span class="flex-shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statutColor }}">
                                {{ $adherent->statut->label() }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $adherent->email }}</p>
                    </div>

                    {{-- Numéro de carte --}}
                    <div class="hidden md:block text-center">
                        <div class="text-xs text-slate-500">N° Carte</div>
                        <div class="text-sm font-mono font-semibold text-indigo-600">{{ $adherent->num_carte }}</div>
                    </div>

                    {{-- Type --}}
                    <div class="hidden lg:block text-center">
                        <div class="text-xs text-slate-500">Type</div>
                        <div class="text-sm text-slate-900 font-medium">{{ $adherent->typeAdherent?->nom ?? '—' }}</div>
                    </div>

                    {{-- Expiration --}}
                    <div class="hidden lg:block text-center">
                        <div class="text-xs text-slate-500">Expiration</div>
                        @if($adherent->date_expiration?->isPast())
                            <div class="text-sm text-red-600 font-medium">{{ $adherent->date_expiration->format('d/m/Y') }}</div>
                        @else
                            <div class="text-sm text-slate-700">{{ $adherent->date_expiration?->format('d/m/Y') ?? '—' }}</div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex-shrink-0 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.adherents.show', $adherent) }}"
                           class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Voir">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.adherents.edit', $adherent) }}"
                           class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Modifier">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.adherents.carte', $adherent) }}"
                           class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Carte PDF">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            @if($adherents->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                {{ $adherents->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
