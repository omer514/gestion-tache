@extends('layouts.master')

@section('content')
    <h1>Détails de la tâche : {{ $tachegroupe->titre }}</h1>

    <p><strong>Groupe :</strong> {{ $tachegroupe->groupe->nom }}</p>
    <p><strong>Auteur :</strong> {{ $tachegroupe->user->name }}</p>
    <p><strong>Contenu :</strong> {{ $tachegroupe->contenu }}</p>
    <p><strong>Date limite :</strong> {{ $tachegroupe->date_limite->format('d/m/Y H:i') }}</p>

    <h3>Rappels personnalisés</h3>

    @if($tachegroupe->rappels->isEmpty())
        <p>Aucun rappel.</p>
    @else
        <ul>
            @foreach($tachegroupe->rappels as $rappel)
                <li>{{ $rappel->user->name }} : {{ $rappel->rappel_at->format('d/m/Y H:i') }}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('rappels.create', $tachegroupe->id) }}" class="btn btn-warning">Ajouter un rappel</a>
    <a href="{{ route('tachegroupes.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
@endsection
