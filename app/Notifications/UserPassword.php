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

class UserPassword extends Notification
{
    use Queueable;
    public $user = null;
    public $password = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TextMessageChannel::class];
    }

    public function toTextMessage($notifiable)
    {
        return TextMessage::create()
            ->to($this->user->mobile)
            ->content('رمز عبور جدید شما:' . $this->password);
    }
}
