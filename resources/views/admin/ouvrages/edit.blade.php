@extends('layouts.admin')

@section('title', 'Modifier — ' . $ouvrage->titre)
@section('header', 'Modifier l\'ouvrage')

@section('content')
<div class="max-w-4xl mx-auto">
    @livewire('admin.ouvrages.ouvrage-form', [
        'categories' => $categories,
        'ouvrage' => $ouvrage
    ])
</div>
@endsection
