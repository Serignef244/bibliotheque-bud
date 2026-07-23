<div x-data="scanner">
    @error('general')
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">{{ $message }}</div>
    @enderror

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Adhérent <span class="text-red-600">*</span></label>
            <div class="flex gap-2">
                <select wire:model.live="adherent_id" class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Sélectionner un adhérent</option>
                    @foreach(\App\Models\Adherent::where('statut', 'actif')->orderBy('nom')->get() as $adherent)
                    <option value="{{ $adherent->id }}">{{ $adherent->nom }} {{ $adherent->prenom }} ({{ $adherent->num_carte }})</option>
                    @endforeach
                </select>
                <button type="button" @click="startScanner()" class="inline-flex items-center justify-center p-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors border border-indigo-200" title="Scanner QR Code">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10v-3.5a2.5 2.5 0 0 1 2.5 -2.5h3.5"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 10v-3.5a2.5 2.5 0 0 0 -2.5 -2.5h-3.5"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 14v3.5a2.5 2.5 0 0 0 2.5 2.5h3.5"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 14v3.5a2.5 2.5 0 0 1 -2.5 2.5h-3.5"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12l0 .01"></path>
                    </svg>
                </button>
            </div>
            @error('adherent_id')
            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Exemplaire <span class="text-red-600">*</span></label>
            <select wire:model.live="exemplaire_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
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
            <input type="date" wire:model="date_emprunt" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="{{ now()->toDateString() }}">
            @error('date_emprunt')
            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">Remarques</label>
            <textarea wire:model="remarques" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" rows="3"></textarea>
        </div>
    </div>

    @if($selectedAdherent)
    <div class="mt-4 p-4 bg-indigo-50 border border-indigo-200 rounded-lg flex items-center gap-4">
        @if($selectedAdherent->photo)
            <img src="{{ $selectedAdherent->photo_url }}" class="w-12 h-12 rounded-lg object-cover ring-2 ring-white">
        @endif
        <div>
            <p class="font-medium text-indigo-900">Adhérent sélectionné: {{ $selectedAdherent->nom }} {{ $selectedAdherent->prenom }}</p>
            <p class="text-sm text-indigo-700">Carte: {{ $selectedAdherent->num_carte }} | Type: {{ $selectedAdherent->typeAdherent->nom }}</p>
        </div>
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
    <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
        <p class="font-medium text-emerald-900">Exemplaire sélectionné: {{ $selectedExemplaire->ouvrage->titre }}</p>
        <p class="text-sm text-emerald-700">Code-barres: {{ $selectedExemplaire->code_barre }}</p>
    </div>
    @endif

    <button type="submit" wire:click="submit" @disabled(!$this->canSubmit) class="mt-6 w-full px-4 py-2 rounded-lg transition font-semibold {{ $this->canSubmit ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-slate-300 text-slate-600 cursor-not-allowed' }}">
        ✓ Enregistrer le prêt
    </button>

    <!-- Modal Scanner QR Code -->
    <div x-show="showScanner" style="display: none" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showScanner" @click="stopScanner()" class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div x-show="showScanner" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-slate-900" id="modal-title">Scanner la carte adhérent</h3>
                            <div class="mt-4 w-full flex justify-center">
                                <div id="reader" class="w-full max-w-sm rounded-lg overflow-hidden border-2 border-indigo-200"></div>
                            </div>
                            <p class="text-xs text-slate-500 mt-2 text-center">Placez le QR Code de la carte devant la caméra.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="stopScanner()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 sm:mt-0 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('scanner', () => ({
                showScanner: false,
                html5QrcodeScanner: null,

                startScanner() {
                    this.showScanner = true;
                    this.$nextTick(() => {
                        this.html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
                        this.html5QrcodeScanner.render((decodedText, decodedResult) => {
                            console.log(`Scan result: ${decodedText}`);
                            this.stopScanner();
                            // Appeler Livewire
                            this.$wire.scannerCarte(decodedText);
                        }, (errorMessage) => {
                            // Erreurs ignorées silencieusement
                        });
                    });
                },

                stopScanner() {
                    this.showScanner = false;
                    if (this.html5QrcodeScanner) {
                        this.html5QrcodeScanner.clear().catch(error => {
                            console.error("Failed to clear html5QrcodeScanner. ", error);
                        });
                        this.html5QrcodeScanner = null;
                    }
                }
            }));
        });
        
        // Listen to livewire event to alert if scan failed
        window.addEventListener('carte-scanned', event => {
            if(!event.detail[0].success) {
                alert("Erreur: Ce QR code n'appartient à aucun adhérent.");
            } else {
                // Succès: L'adhérent est automatiquement sélectionné
            }
        });
    </script>
    @endpush
</div>
