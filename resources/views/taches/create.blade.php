@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-4">Ajouter une tâche</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('taches.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" id="titre" value="{{ old('titre') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="priorite" class="form-label">Priorité</label>
            <select name="priorite" id="priorite" class="form-select" required>
                <option value="faible" {{ old('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                <option value="moyenne" {{ old('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-select" required>
                <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="en_cours" {{ old('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="terminee" {{ old('statut') == 'terminee' ? 'selected' : '' }}>Terminée</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="echeance" class="form-label">Date d'échéance</label>
            <input type="datetime-local" name="echeance" id="echeance" class="form-control" value="{{ old('echeance') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tâche urgente ?</label>
            <div class="form-check">
                <input type="checkbox" name="est_urgente" id="est_urgente" class="form-check-input" value="1" {{ old('est_urgente') ? 'checked' : '' }}>
                <label class="form-check-label" for="est_urgente">Oui, cette tâche est urgente</label>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Créer</button>
        <a href="{{ route('taches.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
