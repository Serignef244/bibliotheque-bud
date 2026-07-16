@extends('layouts.admin')

@section('title', 'Nouvel ouvrage')
@section('header', 'Ajouter un ouvrage')

@section('content')
<div class="max-w-4xl mx-auto">
    @livewire('admin.ouvrages.ouvrage-form', ['categories' => $categories])
</div>
@endsection
