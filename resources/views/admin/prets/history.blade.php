@extends('layouts.admin')

@section('title', 'Historique des prêts')
@section('page-title', '🕓 Historique des prêts')

@section('content')
<div class="space-y-6">
    <div class="flex justify-end">
        <a href="{{ route('admin.prets.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition">
            ← Retour à la liste des prêts
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        @livewire('admin.prets.historique-pret')
    </div>
</div>
@endsection
