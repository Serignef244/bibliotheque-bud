@extends('layouts.admin')

@section('title', 'Gestion des adhérents')
@section('page-title', '👥 Gestion des adhérents')

@section('content')
<div class="space-y-6">
    @livewire('admin.adherents.adherent-table')
</div>
@endsection
