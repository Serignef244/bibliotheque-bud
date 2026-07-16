@extends('layouts.admin')

@section('title', 'Catégories')
@section('header', 'Gestion des catégories')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">Arborescence des catégories de la bibliothèque.</p>
        @can('create', \App\Models\Categorie::class)
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle catégorie
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
        @if($arbre->isEmpty())
            <div class="py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <p class="text-slate-500">Aucune catégorie créée.</p>
            </div>
        @else
        <ul class="divide-y divide-slate-100">
            @foreach($arbre as $categorie)
                @include('admin.categories._noeud', ['categorie' => $categorie, 'niveau' => 0])
            @endforeach
        </ul>
        @endif
    </div>
</div>
@endsection
