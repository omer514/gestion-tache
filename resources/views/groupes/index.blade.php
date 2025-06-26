@extends('layouts.master')

@section('content')
<h1>Mes groupes</h1>

<a href="{{ route('groupes.create') }}" class="btn btn-primary mb-3">Créer un groupe</a>

@foreach($groupes as $groupe)
    <div class="card mb-2">
        <div class="card-body">
            <h5>{{ $groupe->nom }}</h5>
            <p>{{ $groupe->description }}</p>
        </div>
    </div>
@endforeach
@endsection
