@extends('layouts.admin')

@section('title', 'Gestion des ouvrages')
@section('header', 'Catalogue des ouvrages')

@section('content')
<div class="space-y-6">
    @livewire('admin.ouvrages.ouvrage-table')
</div>
@endsection
