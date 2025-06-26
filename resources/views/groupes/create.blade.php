@extends('layouts.master')

@section('content')
<h1>Créer un groupe</h1>

<form action="{{ route('groupes.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="nom" class="form-label">Nom du groupe</label>
        <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Créer</button>
</form>
@endsection
