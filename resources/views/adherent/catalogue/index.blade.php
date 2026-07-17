@extends('layouts.adherent')

@section('title', 'Catalogue')

@section('content')
<div class="space-y-6">
    <div class="mb-8">
        <h1 class="font-poppins text-3xl font-semibold text-slate-900 tracking-tight">Catalogue numérique</h1>
        <p class="text-slate-500 mt-2 text-lg max-w-2xl">Explorez notre collection. Recherchez, découvrez et trouvez votre prochaine lecture parmi des milliers de références.</p>
    </div>

    <livewire:adherent.catalogue.recherche-livre />
</div>
@endsection
