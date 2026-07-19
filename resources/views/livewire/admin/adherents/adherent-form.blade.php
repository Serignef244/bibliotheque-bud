<div>
    <form wire:submit="save" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @if($adherent)
            @method('PUT')
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4">
                <p class="text-sm text-red-400">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Informations personnelles --}}
        <div>
            <h3 class="text-sm font-semibold text-indigo-400 uppercase tracking-wide mb-4">Informations personnelles</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Prénom <span class="text-red-400">*</span></label>
                    <input type="text" wire:model="dto.prenom" required
                           class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    @error('dto.prenom') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Nom <span class="text-red-400">*</span></label>
                    <input type="text" wire:model="dto.nom" required
                           class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    @error('dto.nom') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Email <span class="text-red-400">*</span></label>
                    <input type="email" wire:model="dto.email" required
                           class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    @error('dto.email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Téléphone</label>
                    <input type="text" wire:model="dto.telephone"
                           class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    @error('dto.telephone') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Date de naissance</label>
                    <input type="date" wire:model="dto.date_naissance"
                           class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    @error('dto.date_naissance') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Type d'adhérent <span class="text-red-400">*</span></label>
                    <select wire:model="dto.type_adherent_id" required
                            class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        <option value="">Sélectionner un type</option>
                        @foreach($types as $type)
                            <option value="{{ $type['id'] }}">{{ $type['nom'] }} ({{ $type['duree_jours'] }} jours • {{ $type['max_books'] }} livres max)</option>
                        @endforeach
                    </select>
                    @error('dto.type_adherent_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-300 mb-1">Adresse</label>
                    <textarea wire:model="dto.adresse" rows="2"
                              class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition resize-none"></textarea>
                    @error('dto.adresse') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        @if($adherent)
        {{-- Statut (uniquement pour modification) --}}
        <div>
            <h3 class="text-sm font-semibold text-indigo-400 uppercase tracking-wide mb-4">Statut</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Statut</label>
                    <select wire:model="dto.statut"
                            class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        @foreach(\App\Enums\StatutAdherent::cases() as $statut)
                            <option value="{{ $statut->value }}">{{ $statut->label() ?? $statut->value }}</option>
                        @endforeach
                    </select>
                    @error('dto.statut') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Motif de radiation</label>
                    <input type="text" wire:model="dto.motif_radiation"
                           class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    @error('dto.motif_radiation') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        @endif

        {{-- Photo --}}
        <div>
            <h3 class="text-sm font-semibold text-indigo-400 uppercase tracking-wide mb-4">Photo de profil</h3>
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 bg-white/10 border-2 border-dashed border-white/20 rounded-2xl flex items-center justify-center overflow-hidden">
                    @if($photo)
                        <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                    @elseif($adherent && $adherent->photo)
                        <img src="{{ $adherent->photo_url }}" class="w-full h-full object-cover">
                    @else
                        <svg class="h-10 w-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <input type="file" wire:model="photo" accept="image/*"
                           class="text-sm text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-500/20 file:text-indigo-400 hover:file:bg-indigo-500/30 transition">
                    <p class="text-xs text-slate-400 mt-1">JPG, PNG ou GIF. Max 2 Mo.</p>
                    @error('photo') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
            <a href="{{ route('admin.adherents.index') }}"
               class="px-6 py-2.5 bg-white/10 hover:bg-white/20 text-white text-sm font-medium rounded-xl transition-colors">
                Annuler
            </a>
            <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-indigo-500/25">
                {{ $adherent ? 'Mettre à jour' : 'Inscrire l\'adhérent' }}
            </button>
        </div>
    </form>
</div>
