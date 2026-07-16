<div>
    @error('general')
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">{{ $message }}</div>
    @enderror

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Adhérent <span class="text-red-600">*</span></label>
            <select wire:model.live="adherent_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Sélectionner un adhérent</option>
                @foreach(\App\Models\Adherent::where('statut', 'actif')->orderBy('nom')->get() as $adherent)
                <option value="{{ $adherent->id }}">{{ $adherent->nom }} {{ $adherent->prenom }} ({{ $adherent->num_carte }})</option>
                @endforeach
            </select>
            @error('adherent_id')
            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Exemplaire <span class="text-red-600">*</span></label>
            <select wire:model.live="exemplaire_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Sélectionner un exemplaire</option>
                @foreach($this->exemplairesDisponibles as $exemplaire)
                <option value="{{ $exemplaire->id }}">{{ $exemplaire->ouvrage->titre }} ({{ $exemplaire->code_barre }})</option>
                @endforeach
            </select>
            @error('exemplaire_id')
            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Date d'emprunt <span class="text-red-600">*</span></label>
            <input type="date" wire:model="date_emprunt" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ now()->toDateString() }}">
            @error('date_emprunt')
            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">Remarques</label>
            <textarea wire:model="remarques" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3"></textarea>
        </div>
    </div>

    @if($selectedAdherent)
    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="font-medium text-blue-900">Adhérent sélectionné: {{ $selectedAdherent->nom }} {{ $selectedAdherent->prenom }}</p>
        <p class="text-sm text-blue-700">Carte: {{ $selectedAdherent->num_carte }} | Type: {{ $selectedAdherent->typeAdherent->nom }}</p>
    </div>
    @endif

    @if(!empty($eligibilityErrors))
    <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
        <p class="font-medium text-amber-900">Erreurs d'éligibilité:</p>
        <ul class="mt-2 text-sm text-amber-700 list-disc list-inside">
            @foreach($eligibilityErrors as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if($selectedExemplaire)
    <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
        <p class="font-medium text-green-900">Exemplaire sélectionné: {{ $selectedExemplaire->ouvrage->titre }}</p>
        <p class="text-sm text-green-700">Code-barres: {{ $selectedExemplaire->code_barre }}</p>
    </div>
    @endif

    <button type="submit" wire:click="submit" @disabled(!$this->canSubmit) class="mt-6 w-full px-4 py-2 rounded-lg transition {{ $this->canSubmit ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-slate-300 text-slate-600 cursor-not-allowed' }}">
        ✓ Enregistrer le prêt
    </button>
</div>
