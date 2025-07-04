@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Créer un nouveau groupe</h2>

    <form method="POST" action="{{ route('groupes.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du groupe</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
