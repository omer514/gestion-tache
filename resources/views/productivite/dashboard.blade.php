@extends('layouts.master')

@section('content')
<div class="container mt-4">

    <!-- Titre centré -->
    <h2 class="text-center mb-4">Page de Productivité</h2>

    <!-- Ligne contenant infos à gauche et badges à droite -->
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
        <!-- Partie gauche -->
        <div>
            <p><strong>Utilisateur :</strong> {{ $user->name }}</p>
            <p><strong>Niveau :</strong> {{ $user->niveau }}</p>
        </div>

        <!-- Partie droite -->
        <div class="text-end">
            <p><strong>Score total :</strong> {{ $user->total_score }}</p>
            <div>
                <strong>Badges obtenus :</strong>
                <div>
                    @foreach($badges as $badge)
                        <span class="badge bg-primary me-1 mb-1" title="{{ $badge->description }}">
                            <i class="fa {{ $badge->icone }}"></i> {{ $badge->nom }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique -->
    <h4>Évolution du score (par jour)</h4>
    <canvas id="scoreChart" width="600" height="300"></canvas>

</div>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Chart.js -->
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
