@extends('layouts.master')

@section('content')
    <h1>Créer une nouvelle tâche partagée dans un groupe</h1>

    <form action="{{ route('tachegroupes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre') }}" required>
            @error('titre') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="contenu" class="form-label">Contenu</label>
            <textarea name="contenu" id="contenu" class="form-control" rows="4" required>{{ old('contenu') }}</textarea>
            @error('contenu') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="date_limite" class="form-label">Date limite</label>
            <input type="datetime-local" name="date_limite" id="date_limite" class="form-control" value="{{ old('date_limite') }}" required>
            @error('date_limite') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="groupe_id" class="form-label">Groupe</label>
            <select name="groupe_id" id="groupe_id" class="form-select" required>
               <div class="mb-3">
    <label class="form-label">Groupe</label>
    <input type="hidden" name="groupe_id" value="{{ $groupe->id }}">
    <input type="text" class="form-control" value="{{ $groupe->nom }}" disabled>
</div>

            </select>
            @error('groupe_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Créer</button>
    </form>
@endsection
