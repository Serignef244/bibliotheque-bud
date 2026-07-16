@extends('layouts.admin')

@section('title', 'Détails du prêt')
@section('page-title', '📖 Détails du prêt #{{ $pret->id }}')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-4">Informations du prêt</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-slate-600">Adhérent:</span>
                        <p class="font-medium">{{ $pret->adherent->nom }} {{ $pret->adherent->prenom }}
                            <span class="inline-block ml-2 px-2 py-1 text-xs bg-slate-100 rounded">{{ $pret->adherent->num_carte }}</span>
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-slate-600">Ouvrage:</span>
                        <p class="font-medium">{{ $pret->exemplaire->ouvrage->titre }}
                            <span class="inline-block ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">{{ $pret->exemplaire->code_barre }}</span>
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-slate-600">Date d'emprunt:</span>
                        <p class="font-medium">{{ $pret->date_emprunt->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-slate-600">Date de retour prévue:</span>
                        <p class="font-medium {{ $pret->estEnRetard() ? 'text-red-600' : '' }}">{{ $pret->date_retour_prevue->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-slate-600">Statut:</span>
                        <p>
                            @if($pret->statut === 'en_cours')
                                <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded">En cours</span>
                            @elseif($pret->statut === 'rendu')
                                <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Rendu</span>
                            @elseif($pret->statut === 'retard')
                                <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-800 rounded">En retard</span>
                            @endif
                        </p>
                    </div>
                    @if($pret->date_retour_reelle)
                    <div>
                        <span class="text-sm text-slate-600">Date de retour effective:</span>
                        <p class="font-medium">{{ $pret->date_retour_reelle->format('d/m/Y') }}</p>
                    </div>
                    @endif
                    @if($pret->remarques)
                    <div>
                        <span class="text-sm text-slate-600">Remarques:</span>
                        <p class="font-medium">{{ $pret->remarques }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Actions</h3>
                <div class="space-y-3">
                    @if($pret->statut === 'en_cours' || $pret->statut === 'retard')
                    <form action="{{ route('admin.prets.return', $pret->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            ✓ Enregistrer le retour
                        </button>
                    </form>

                    @if($pret->peutEtreProlonge())
                    <form action="{{ route('admin.prets.prolonger', $pret->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition">
                            🕐 Prolonger le prêt
                        </button>
                    </form>
                    @endif
                    @endif

                    <a href="{{ route('admin.prets.history') }}" class="block w-full text-center bg-slate-100 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-200 transition">
                        🕓 Voir l'historique
                    </a>
                </div>

                @if($pret->estEnRetard())
                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <h4 class="font-semibold text-red-800 mb-2">⚠️ Retard</h4>
                    <p class="text-sm text-red-700">Ce prêt est en retard de {{ $pret->joursDeRetard() }} jour(s).</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
