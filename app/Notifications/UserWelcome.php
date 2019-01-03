<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Channels\TextMessageChannel;
use App\Channels\TextMessage;

class UserWelcome extends Notification
{
    use Queueable;
    public $user = null;
    public $password = null;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail', TextMessageChannel::class];
    }

    public function toMail($notifiable)
    {
        $url = url('');
        return (new MailMessage)
            ->subject('عضویت شما در وب سایت ' . config('platform.name'))
            ->line($this->user->name . " عضویت شما را در " . config('platform.name') . " خوش آمد می گویم.")
            ->line("رمز عبور شما:" . $this->password . " می باشد.")
            ->action("مشاهده وب سایت", $url);
    }

    public function toTextMessage($notifiable)
    {
        $url = url('');
        return TextMessage::create()
            ->to($this->user->mobile)
            ->content($this->user->name . " عضویت شما را در " . config('platform.name') . " خوش آمد می گویم.\n" . "رمز عبور موقت شما:" . $this->password . " \n " . $url);
    }
}
