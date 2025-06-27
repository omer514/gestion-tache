@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2 class="text-primary">Liste des tâches</h2>
        <a href="{{ route('taches.create') }}" class="btn btn-success">Ajouter une tâche</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th>Titre</th>
                <th>Priorité</th>
                <th>Statut</th>
                <th>Échéance</th>
                <th>Urgente</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($taches as $tache)
            <tr>
                <td>{{ $tache->titre }}</td>
                <td>{{ ucfirst($tache->priorite) }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $tache->statut)) }}</td>
                <td>{{ $tache->echeance }}</td>
                <td>{{ $tache->est_urgente ? 'Oui' : 'Non' }}</td>
                <td>
                    @if($tache->user_id === Auth()->id())
                        <a href="{{ route('taches.edit', $tache) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('taches.destroy', $tache) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Supprimer cette tâche ?')" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    @else
                        <em class="text-muted">Aucune action</em>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Aucune tâche trouvée.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $taches->links() }}
</div>
@endsection
