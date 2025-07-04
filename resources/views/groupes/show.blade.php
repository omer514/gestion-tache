@extends('layouts.master')

@section('title', 'Détails du Groupe')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3">Groupe : {{ $groupe->nom }}</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Membres du Groupe</h5>
            <a href="{{ route('groupes.inviter.form', $groupe) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-user-plus"></i> Inviter un membre
            </a>
        </div>
        <div class="card-body">
            @if($groupe->membres->count() > 0)
                <ul class="list-group">
                    @foreach($groupe->membres as $membre)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $membre->name }}
                            <small class="text-muted">{{ $membre->email }}</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Aucun membre pour le moment.</p>
            @endif
        </div>
    </div>
</div>
@endsection
