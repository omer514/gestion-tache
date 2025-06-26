@extends('layouts.master')

@section('content')
    <h1>Ajouter un rappel personnalisé pour la tâche : {{ $tache->titre }}</h1>

    <form action="{{ route('rappels.store', $tache->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="rappel_at" class="form-label">Date et heure du rappel</label>
            <input type="datetime-local" name="rappel_at" id="rappel_at" class="form-control" value="{{ old('rappel_at') }}" required>
            @error('rappel_at') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer le rappel</button>
    </form>
@endsection
