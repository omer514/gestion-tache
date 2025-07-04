@extends('layouts.master') {{-- ou layouts.app si c’est ton layout principal --}}

@section('title', 'Créer une tâche pour le groupe')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Créer une tâche - Groupe : {{ $groupe->nom }}</h1>
      </div>
      <div class="col-sm-6 text-right">
        <a href="{{ route('groupes.show', $groupe) }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Retour au groupe
        </a>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Nouvelle tâche</h3>
      </div>

      <form method="POST" action="{{ route('taches.storeGroupe', $groupe) }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="nom">Nom de la tâche</label>
            <input type="text" name="nom" class="form-control" id="nom" required placeholder="Entrez le nom de la tâche">
          </div>

          <div class="form-group">
            <label for="echeance">Date d'échéance</label>
            <input type="datetime-local" name="echeance" class="form-control" id="echeance" required>
          </div>

          <div class="form-group">
            <label for="priorite">Priorité</label>
            <select name="priorite" class="form-control">
                  <option value="basse">Basse</option>
                  <option value="moyenne">Moyenne</option>
                  <option value="haute">Haute</option>
          </select>
          </div>

          <div class="form-group">
            <label for="assignee_id">Assigner à un membre (optionnel)</label>
            <select name="assignee_id" id="assignee_id" class="form-control">
              <option value="">-- Aucun --</option>
              @foreach ($membres as $membre)
                <option value="{{ $membre->id }}">{{ $membre->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-success">
            <i class="fas fa-check-circle"></i> Créer la tâche
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
