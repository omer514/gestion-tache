@extends('layouts.master')

@section('title', 'Liste des tâches - Groupe : ' . $groupe->nom)

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Liste des tâches - Groupe : {{ $groupe->nom }}</h1>
      </div>
      <div class="col-sm-6 text-right">
        <a href="{{ route('taches.createGroupe', $groupe) }}" class="btn btn-primary">
          <i class="fas fa-plus"></i> Créer une nouvelle tâche
        </a>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tâches du groupe</h3>
      </div>
      <div class="card-body table-responsive p-0">
        @if($taches->count())
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Échéance</th>
              <th>Priorité</th>
              <th>Assignée à</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($taches as $tache)
            <tr>
              <td>{{ $tache->nom }}</td>
              <td>{{ $tache->echeance ? \Carbon\Carbon::parse($tache->echeance)->format('d/m/Y H:i') : '—' }}</td>
              <td>{{ ucfirst($tache->priorite) }}</td>
              <td>{{ $tache->assignee ? $tache->assignee->name : '—' }}</td>
              <td>{{ ucfirst($tache->statut ?? 'en cours') }}</td>
              <td>
                {{-- Boutons modifier / supprimer ou autres actions --}}
                <a href="{{ route('taches.edit', $tache) }}" class="btn btn-sm btn-warning" title="Modifier"><i class="fas fa-edit"></i></a>
                <form action="{{ route('taches.destroy', $tache) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger" title="Supprimer"><i class="fas fa-trash"></i></button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <p class="m-3 text-muted">Aucune tâche pour ce groupe.</p>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
