@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2>Dashboard de Productivité</h2>

    <p><strong>Utilisateur :</strong> {{ $user->name }}</p>
    <p><strong>Niveau :</strong> {{ $user->niveau }}</p>
    <p><strong>Score total :</strong> {{ $user->total_score }}</p>

    <h4>Badges obtenus</h4>
    <div class="mb-4">
        @foreach($badges as $badge)
            <span class="badge bg-primary me-2" title="{{ $badge->description }}">
                <i class="fa {{ $badge->icone }}"></i> {{ $badge->nom }}
            </span>
        @endforeach
    </div>

    <h4>Évolution du score (par jour)</h4>
    <canvas id="scoreChart" width="600" height="300"></canvas>

</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    const ctx = document.getElementById('scoreChart').getContext('2d');
    const scoreChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dates) !!},
            datasets: [{
                label: 'Score gagné',
                data: {!! json_encode($scores) !!},
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.1,
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
