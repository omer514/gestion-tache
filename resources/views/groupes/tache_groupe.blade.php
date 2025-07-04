@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Groupe : {{ $groupe->nom }}</h2>

    <p><strong>Description :</strong> {{ $groupe->description }}</p>
    <p><strong>Créé par :</strong> {{ $groupe->createur->name }}</p>

    <hr>

    <h4>Membres du groupe</h4>
    <ul>
        @foreach($groupe->membres as $membre)
            <li>{{ $membre->name }}</li>
        @endforeach
    </ul>

    <hr>

    <h4 class="mt-4">Tâches du groupe</h4>

    <a href="{{ route('taches.createGroupe', $groupe) }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Ajouter une tâche
    </a>

    @if($groupe->taches->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Titre</th>
                    <th>Échéance</th>
                    <th>Statut</th>
                    <th>Priorité</th>
                    <th>Assignée à</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupe->taches as $tache)
                <tr class="{{ $tache->statut === 'terminee' ? 'table-success' : ($tache->echeance && \Carbon\Carbon::parse($tache->echeance)->isPast() ? 'table-danger' : '') }}">
                    <td>{{ $tache->titre }}</td>
                    <td>{{ $tache->echeance ? \Carbon\Carbon::parse($tache->echeance)->format('d/m/Y H:i') : '—' }}</td>
                    <td>{{ ucfirst($tache->statut) }}</td>
                    <td>{{ ucfirst($tache->priorite) }}</td>
                    <td>{{ $tache->assignee ? $tache->assignee->name : '—' }}</td>
                    <td>
                        @if(in_array(Auth::id(), [$tache->assignee_id, $groupe->createur_id]) && $tache->statut !== 'terminee')
                            <form action="{{ route('taches.marquerTerminee', $tache) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-check"></i> Terminer
                                </button>
                            </form>
                        @else
                            <span class="text-muted">Aucune action</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-muted">Aucune tâche pour ce groupe.</p>
    @endif
</div>
@endsection
