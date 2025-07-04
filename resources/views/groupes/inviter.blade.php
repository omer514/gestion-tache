@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Inviter un utilisateur dans le groupe : {{ $groupe->nom }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('groupes.inviter', $groupe) }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Adresse email de l’utilisateur</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Envoyer l’invitation</button>
    </form>
</div>
@endsection
