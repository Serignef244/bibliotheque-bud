@extends('layouts.admin')

@section('header', 'Tableau de bord')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
    @foreach ([
        ['label' => 'Ouvrages', 'value' => $stats['ouvrages'], 'color' => 'bg-blue-500'],
        ['label' => 'Adhérents actifs', 'value' => $stats['adherents_actifs'], 'color' => 'bg-green-500'],
        ['label' => 'Prêts en cours', 'value' => $stats['prets_en_cours'], 'color' => 'bg-amber-500'],
        ['label' => 'Pénalités impayées', 'value' => $stats['penalites_impayees'], 'color' => 'bg-red-500'],
    ] as $stat)
        <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-lg {{ $stat['color'] }} opacity-90"></div>
                <div>
                    <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-8 rounded-xl bg-white p-6 shadow-sm border border-slate-200">
    <h2 class="text-lg font-semibold text-slate-900">Bienvenue sur l'espace d'administration de la Bibliothèque BUD</h2>
    <p class="mt-2 text-slate-600">Vous pouvez désormais naviguer à travers les différents modules à l'aide de la barre latérale pour gérer votre bibliothèque.</p>
</div>
@endsection
