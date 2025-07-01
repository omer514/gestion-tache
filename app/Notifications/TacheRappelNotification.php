<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class TacheRappelNotification extends Notification
{
    use Queueable;

    public $tache;

    public function __construct($tache)
    {
        $this->tache = $tache;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Rappel de tâche')
            ->icon('/icons/icon-512x512.png')
            ->body("⏰ N'oubliez pas votre tâche : {$this->tache->titre}")
            ->data(['url' => url('/taches')])
            ->action('Voir', url('/taches'))
            ->vibrate([200, 100, 200])
            ->badge('/icons/badge.png');
    }
}
