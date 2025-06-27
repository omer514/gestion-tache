@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Modifier la tâche</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('taches.update', $tache) }}" method="POST">
        @csrf @method('PUT')

        

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ $tache->titre }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control">{{ $tache->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="priorite" class="form-label">Priorité</label>
            <select name="priorite" id="priorite" class="form-select">
                @foreach(['faible', 'moyenne', 'haute'] as $p)
                    <option value="{{ $p }}" @if($tache->priorite == $p) selected @endif>{{ ucfirst($p) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-select">
                @foreach(['en_attente', 'en_cours', 'terminee'] as $s)
                    <option value="{{ $s }}" @if($tache->statut == $s) selected @endif>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="echeance" class="form-label">Échéance</label>
            <input type="datetime-local" name="echeance" id="echeance" class="form-control"
                value="{{ $tache->echeance ? \Carbon\Carbon::parse($tache->echeance)->format('Y-m-d\TH:i') : '' }}">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="est_urgente" id="est_urgente" value="1" {{ $tache->est_urgente ? 'checked' : '' }}>
            <label class="form-check-label" for="est_urgente">Urgente</label>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
