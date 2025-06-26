@extends('layouts.master')

@section('content')
    <h1>Liste des tâches partagées dans mes groupes</h1>

    <a href="{{ route('tachegroupes.create') }}" class="btn btn-primary mb-3">Créer une nouvelle tâche</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($taches->isEmpty())
        <p>Aucune tâche trouvée.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Groupe</th>
                    <th>Auteur</th>
                    <th>Date limite</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($taches as $tache)
                    <tr>
                        <td>{{ $tache->titre }}</td>
                        <td>{{ $tache->groupe->nom }}</td>
                        <td>{{ $tache->user->name }}</td>
                        <td>{{ $tache->date_limite->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('tachegroupes.show', $tache) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('rappels.create', $tache) }}" class="btn btn-warning btn-sm">Ajouter un rappel</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
