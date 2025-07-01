<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tache;
use Carbon\Carbon;
use App\Notifications\TacheRappelNotification;

class RappelTachesCommand extends Command
{
    protected $signature = 'taches:rappels';
    protected $description = 'Envoyer des rappels de tâches (24h et 30min avant)';

    public function handle()
    {
        $now = Carbon::now();

        $taches = Tache::whereNotNull('echeance')
            ->where('statut', '!=', 'terminee')
            ->where(function($q) use ($now) {
                $q->whereBetween('echeance', [$now->copy()->addDay()->startOfMinute(), $now->copy()->addDay()->addMinutes(1)])
                  ->orWhereBetween('echeance', [$now->copy()->addMinutes(30)->startOfMinute(), $now->copy()->addMinutes(31)]);
            })->get();

        foreach ($taches as $tache) {
            $tache->user->notify(new TacheRappelNotification($tache));
        }

        $this->info("Notifications envoyées.");
    }
}
