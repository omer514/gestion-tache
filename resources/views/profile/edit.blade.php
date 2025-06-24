@extends('pages.dashboard') {{-- ou ton propre layout --}}

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Modifier mon profil</h4>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">
            Profil mis à jour avec succès.
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Nom -->
        <div class="form-group mb-3">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', auth()->user()->name) }}" required autofocus>
        </div>

        <!-- Email -->
        <div class="form-group mb-3">
            <label for="email">Adresse e-mail</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
