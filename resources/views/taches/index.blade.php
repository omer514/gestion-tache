@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <h2 class="text-primary">Liste des tâches</h2>
        
        <div>
            <a href="{{ route('taches.create') }}" class="btn btn-success me-2">Ajouter une tâche</a>

            {{-- Bouton pour mettre à jour les tâches échues --}}
            <form action="{{ route('taches.majStatut') }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la mise à jour des tâches échues ?')">
    @csrf
    <button type="submit" class="btn btn-warning">Mettre à jour les tâches échues</button>
</form>

        </div>
    </div>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulaire de filtre --}}
    <form method="GET" action="{{ route('taches.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="statut" class="form-select">
                <option value="">-- Statut --</option>
                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="terminee" {{ request('statut') == 'terminee' ? 'selected' : '' }}>Terminée</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="priorite" class="form-select">
                <option value="">-- Priorité --</option>
                <option value="faible" {{ request('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                <option value="haute" {{ request('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="echeance" value="{{ request('echeance') }}" class="form-control" placeholder="Échéance">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filtrer</button>
        </div>
    </form>

    {{-- Tableau des tâches --}}
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
            @php
                $estEnRetard = $tache->echeance && $tache->statut !== 'terminee' && \Carbon\Carbon::parse($tache->echeance)->isPast();
            @endphp
            <tr 
                @if($estEnRetard)
                    style="background-color: #f8d7da;" {{-- rouge clair pour tâches en retard --}}
                @elseif($tache->est_urgente)
                    style="background-color: #ffe5e5;" {{-- rose clair pour tâches urgentes --}}
                @endif
            >
                <td>{{ $tache->titre }}</td>
                <td>{{ ucfirst($tache->priorite) }}</td>
                <td>
                    {{ ucfirst(str_replace('_', ' ', $tache->statut)) }}
                    @if($estEnRetard)
                        <span class="badge bg-danger ms-1">En retard</span>
                    @endif
                </td>
                <td>
                    {{ $tache->echeance ? \Carbon\Carbon::parse($tache->echeance)->format('d/m/Y H:i') : '-' }}
                </td>
                <td>
                    @if($tache->est_urgente)
                        <span class="badge bg-danger">Oui</span>
                    @else
                        Non
                    @endif
                </td>
                <td class="d-flex gap-1 flex-wrap">
                    @if($tache->user_id === Auth::id())
                        {{-- Modifier --}}
                        <a href="{{ route('taches.edit', $tache) }}" class="btn btn-sm btn-warning">Modifier</a>

                        {{-- Supprimer --}}
                        <form action="{{ route('taches.destroy', $tache) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Supprimer cette tâche ?')" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>

                        {{-- Terminer (si pas encore terminée) --}}
                        @if($tache->statut !== 'terminee')
                        <form action="{{ route('taches.terminer', $tache) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button class="btn btn-sm btn-success">Terminer</button>
                        </form>
                        @endif
                    @else
                        <em class="text-muted">Aucune action</em>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">Aucune tâche trouvée.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $taches->withQueryString()->links() }}
    </div>
</div>
@endsection
