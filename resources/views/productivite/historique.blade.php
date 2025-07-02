@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Historique de productivité</h2>

    <p><span class="badge bg-primary">Niveau :</span> {{ Auth::user()->niveau }}</p>
    <p><span class="badge bg-success">Score total :</span> {{ Auth::user()->total_score }}</p>

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

    <div class="d-flex justify-content-center">
        {{ $evolutions->links() }}
    </div>
</div>
@endsection
