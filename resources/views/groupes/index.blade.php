@extends('layouts.master')

@section('title', 'Mes Groupes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Mes Groupes</h1>
        <a href="{{ route('groupes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau Groupe
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($groupes->count() > 0)
        <div class="row">
            @foreach ($groupes as $groupe)
                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $groupe->nom }}</h5>
                            @if($groupe->createur_id === auth()->id())
                                <span class="badge bg-success mb-2">Créateur</span>
                            @endif
                            <a href="{{ route('groupes.show', $groupe) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i> Voir le groupe
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">Vous ne faites partie d’aucun groupe pour le moment.</p>
    @endif
</div>
@endsection
