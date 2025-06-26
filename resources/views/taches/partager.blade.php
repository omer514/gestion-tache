@extends('layouts.master')

@section('content')
<h1>Partager une tâche</h1>

<form action="{{ route('taches.storePartage') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="groupe_id" class="form-label">Choisir un groupe :</label>
        <select name="groupe_id" id="groupe_id" class="form-control" required>
            <option value="">-- Sélectionner un groupe --</option>
            @foreach($groupes as $groupe)
                <option value="{{ $groupe->id }}">{{ $groupe->nom }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="titre" class="form-label">Titre de la tâche :</label>
        <input type="text" name="titre" id="titre" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Partager la tâche</button>
</form>
@endsection
