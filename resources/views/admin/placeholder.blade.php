@extends('layouts.admin')

@section('header', $title ?? 'Module')

@section('content')
<div class="rounded-xl bg-white p-8 shadow-sm border border-slate-200 text-center">
    <h2 class="text-xl font-semibold text-slate-900">{{ $title ?? 'Module' }}</h2>
    <p class="mt-2 text-slate-600">Ce module sera disponible dans une prochaine phase de développement.</p>
</div>
@endsection
