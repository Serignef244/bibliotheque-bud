@extends('layouts.adherent')

@section('title', 'Détails du prêt')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Détails du prêt #{{ $pret->id }}</h2>
        <a href="{{ route('adherent.prets.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations du prêt</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-muted">Ouvrage</label>
                            <div class="fw-semibold">{{ $pret->exemplaire->ouvrage->titre }}</div>
                            <small class="text-muted">{{ $pret->exemplaire->ouvrage->auteur }}</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Code-barres</label>
                            <div class="fw-semibold">{{ $pret->exemplaire->code_barre }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Date d'emprunt</label>
                            <div class="fw-semibold">{{ $pret->date_emprunt->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Date de retour prévue</label>
                            <div class="fw-semibold {{ $pret->estEnRetard() ? 'text-danger' : '' }}">
                                {{ $pret->date_retour_prevue->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Statut</label>
                            <div>
                                @if($pret->statut === 'en_cours')
                                    <span class="badge bg-success">En cours</span>
                                @elseif($pret->statut === 'rendu')
                                    <span class="badge bg-primary">Rendu</span>
                                @elseif($pret->statut === 'retard')
                                    <span class="badge bg-danger">En retard</span>
                                @endif
                            </div>
                        </div>
                        @if($pret->date_retour_effective)
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Date de retour effective</label>
                            <div class="fw-semibold">{{ $pret->date_retour_effective->format('d/m/Y') }}</div>
                        </div>
                        @endif
                        @if($pret->remarques)
                        <div class="col-12 mb-3">
                            <label class="form-label text-muted">Remarques</label>
                            <div>{{ $pret->remarques }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    @if($pret->statut === 'en_cours' || $pret->statut === 'retard')
                        @if($pret->peutEtreProlonge())
                        <form action="{{ route('adherent.prets.prolonger', $pret->id) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="bi bi-clock-history me-2"></i>Prolonger le prêt
                            </button>
                        </form>
                        @else
                        <div class="alert alert-info mb-3">
                            <small>La prolongation n'est plus disponible pour ce prêt.</small>
                        </div>
                        @endif
                    @endif

                    <a href="{{ route('adherent.prets.history') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-clock me-2"></i>Voir l'historique
                    </a>
                </div>
            </div>

            @if($pret->estEnRetard())
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-exclamation-triangle me-2"></i>Retard</h5>
                    <p class="mb-0">Ce prêt est en retard de {{ $pret->joursDeRetard() }} jour(s).</p>
                    <p class="mb-0 small">Veuillez retourner l'ouvrage dès que possible.</p>
                </div>
            </div>
            @endif

            @if($pret->statut === 'en_cours' && !$pret->estEnRetard())
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-check-circle me-2"></i>En cours</h5>
                    <p class="mb-0">Ce prêt est en cours et doit être retourné le {{ $pret->date_retour_prevue->format('d/m/Y') }}.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
