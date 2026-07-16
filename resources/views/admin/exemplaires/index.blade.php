@extends('layouts.admin')

@section('title', 'Gestion des exemplaires')
@section('header', 'Exemplaires')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Exemplaires de l'ouvrage</h1>
            <p class="text-sm text-gray-600">{{ $ouvrage->titre }}</p>
        </div>
        <a href="{{ route('admin.ouvrages.exemplaires.create', $ouvrage) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            Ajouter un exemplaire
        </a>
    </div>

    @if($exemplaires->isEmpty())
        <div class="rounded-lg border border-dashed border-gray-300 bg-white p-8 text-center text-sm text-gray-600">
            Aucun exemplaire n'a encore été ajouté à cet ouvrage.
        </div>
    @else
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Code-barres</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Cote</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">État</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($exemplaires as $exemplaire)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $exemplaire->code_barre }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $exemplaire->cote ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $exemplaire->statut ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $exemplaire->etat ?? '—' }}</td>
                            <td class="px-4 py-3 text-right text-sm">
                                <a href="{{ route('admin.exemplaires.show', ['ouvrage' => $ouvrage, 'exemplaire' => $exemplaire]) }}" class="text-indigo-600 hover:text-indigo-800">Voir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
