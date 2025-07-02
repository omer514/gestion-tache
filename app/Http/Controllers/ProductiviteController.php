<?php

// app/Http/Controllers/ProductiviteController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ScoreEvolution;

class ProductiviteController extends Controller
{
    public function historique()
    {
        $evolutions = ScoreEvolution::where('user_id', Auth::id())
            ->orderByDesc('recorded_at')
            ->paginate(15);

        return view('productivite.historique', compact('evolutions'));
    }


    public function dashboard()
{
    $user = Auth::user();

    // Récupérer score évolutions groupées par date (exemple : par jour)
    $scoresParJour = ScoreEvolution::where('user_id', $user->id)
        ->selectRaw('DATE(recorded_at) as date, SUM(score) as total_score')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Préparer données pour Chart.js
    $dates = $scoresParJour->pluck('date')->map(fn($d) => date('d/m', strtotime($d)))->toArray();
    $scores = $scoresParJour->pluck('total_score')->toArray();

    // Récupérer badges actuels
    $badges = $user->badges;

    return view('productivite.dashboard', compact('user', 'dates', 'scores', 'badges'));
}

}
