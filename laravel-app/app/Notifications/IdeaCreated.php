<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Idea;

class IdeaCreated extends Notification
{
    use Queueable;

    public $idea;

    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Hai inserito una nuova Idea!') 
                    ->greeting('Ciao ' . $notifiable->name . '!') 
                    ->line('Grazie per aver condiviso la tua idea con noi.')
                    ->action('Visualizza la tua Idea', url('/ideas/' . $this->idea->id)) 
                    ->line('Speriamo venga approvata presto!');
    }
}
