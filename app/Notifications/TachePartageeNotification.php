<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Tache;

class TachePartageeNotification extends Notification
{
    use Queueable;

    protected $tache;

    public function __construct(Tache $tache)
    {
        $this->tache = $tache;
    }

    // Canaux de notification : mail et base de données
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    // Notification par mail
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Bonjour ' . $notifiable->name)
                    ->line('Une nouvelle tâche a été partagée avec vous dans le groupe : ' . $this->tache->groupe->nom)
                    ->line('Titre : ' . $this->tache->titre)
                    ->action('Voir la tâche', url(route('taches.show', $this->tache->id)))
                    ->line('Merci d\'utiliser notre application.');
    }

    // Notification stockée en base de données
    public function toDatabase($notifiable)
    {
        return [
            'tache_id' => $this->tache->id,
            'titre' => $this->tache->titre,
            'groupe' => $this->tache->groupe->nom,
            'message' => 'Une tâche vous a été partagée',
        ];
    }
}
