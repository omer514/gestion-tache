@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Créer une nouvelle tâche</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('taches.store') }}" method="POST">
        @csrf

        
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="priorite" class="form-label">Priorité</label>
            <select name="priorite" id="priorite" class="form-select" required>
                <option value="faible">Faible</option>
                <option value="moyenne" selected>Moyenne</option>
                <option value="haute">Haute</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-select">
                <option value="en_attente" selected>En attente</option>
                <option value="en_cours">En cours</option>
                <option value="terminee">Terminée</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="echeance" class="form-label">Échéance</label>
            <input type="datetime-local" name="echeance" id="echeance" class="form-control">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="est_urgente" id="est_urgente" value="1">
            <label class="form-check-label" for="est_urgente">Urgente</label>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
