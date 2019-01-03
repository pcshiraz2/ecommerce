<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use App\Channels\TextMessageChannel;
use App\Channels\TextMessage;


class TicketCreated extends Notification
{
    use Queueable;
    public $ticket = null;
    public $user = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket, $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', TextMessageChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('ticket.view', [$this->ticket->id]);
        return (new MailMessage)
            ->subject('تیکت جدید با عنوان:' . $this->ticket->title)
            ->line('تیکت جدید با عنوان ' . $this->ticket->title . 'ایجاد شد.')
            ->action('مشاهده تیکت', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => "تیکت با عنوان " . $this->ticket->title . " ثبت شد.",
            'url' => route('ticket.view', [$this->ticket->id]),
        ];
    }

    public function toTelegram($notifiable)
    {
        $url = route('ticket.view', ['id' => $this->ticket->id]);
        return TelegramMessage::create()
            ->to($this->user->telegram_user_id)
            ->content("تیکت جدید با عنوان:" . $this->ticket->title)// Markdown supported.
            ->button('نمایش تیکت', $url);

    }

    public function toTextMessage($notifiable)
    {
        $url = route('ticket.view', ['id' => $this->ticket->id]);
        return TextMessage::create()
            ->to($this->user->mobile)
            ->content('تیکت جدید با عنوان:' . $this->ticket->title . ' مشاهده:' . $url);
    }
}
