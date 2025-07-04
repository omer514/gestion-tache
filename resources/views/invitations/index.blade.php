@extends('layouts.master')

@section('title', 'Mes Invitations')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Mes Invitations</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($invitations->count() > 0)
        <div class="card shadow-sm">
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($invitations as $invitation)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fas fa-users me-2"></i>
                                Invitation au groupe : <strong>{{ $invitation->groupe->nom }}</strong>
                            </span>
                            <form method="POST" action="{{ route('invitations.accepter', $invitation) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i> Accepter
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        <p class="text-muted">Aucune invitation en attente.</p>
    @endif
</div>
@endsection
