@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <!-- Titre centré -->
    <h2 class="text-center mb-4">Historique de productivité</h2>

    <!-- Ligne avec niveau à gauche et score à droite -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="mb-0">
            <span class="badge bg-primary">Niveau :</span> {{ Auth::user()->niveau }}
        </p>
        <p class="mb-0">
            <span class="badge bg-success">Score total :</span> {{ Auth::user()->total_score }}
        </p>
    </div>

    <!-- Tableau des évolutions -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Action</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evolutions as $evo)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($evo->recorded_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ $evo->action }}</td>
                    <td><strong class="text-success">+{{ $evo->score }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $evolutions->links() }}
    </div>
</div>
@endsection
