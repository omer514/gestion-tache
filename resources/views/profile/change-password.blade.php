@extends('layouts.master') {{-- ou layouts.app selon ton layout --}}

@section('title', 'Changer mot de passe')

@section('content')
<div class="container mt-4">
    <h3>Changer votre mot de passe</h3>

    @if (session('status') === 'password-updated')
        <div class="alert alert-success">
            Mot de passe mis à jour avec succès.
        </div>
    @endif

    <form method="POST" action="{{ route('password.change.update') }}">
        @csrf

        <div class="mb-3">
            <label for="current_password">Mot de passe actuel</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>
@endsection
