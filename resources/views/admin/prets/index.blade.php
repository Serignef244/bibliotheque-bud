@extends('layouts.admin')

@section('title', 'Gestion des prêts')
@section('page-title', '📚 Gestion des prêts')

@section('content')
<div class="space-y-6">
    @livewire('admin.prets.pret-table')
</div>
@endsection
