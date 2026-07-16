@extends('layouts.admin')

@section('title', 'Gestion des pénalités')
@section('page-title', '💰 Gestion des pénalités')

@section('content')
<div class="max-w-7xl mx-auto">
    <livewire:admin.penalites.penalite-table />
</div>
@endsection
