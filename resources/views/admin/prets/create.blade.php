@extends('layouts.admin')

@section('title', 'Nouveau prêt')
@section('page-title', '➕ Nouveau prêt')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.prets.store') }}" method="POST" id="pretForm">
            @csrf
            @livewire('admin.prets.pret-form')
        </form>
    </div>
</div>

