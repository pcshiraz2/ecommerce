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

class DiscussionCreated extends Notification
{
    use Queueable;
    public $discussion = null;
    public $user = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($discussion, $user)
    {
        $this->user = $user;
        $this->discussion = $discussion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('discussion.view', [$this->discussion->id]);
        return (new MailMessage)
            ->subject('ایجاد بحث جدید با عنوان:' . $this->discussion->title)
            ->line('بحث جدید با عنوان' . $this->discussion->title . 'ایجاد شد.')
            ->action('مشاهده بحث', $url);
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
            'title' => "بحث جدید با عنوان " . $this->discussion->title . "  ثبت شد.",
            'url' => route('discussion.view', [$this->discussion->id]),
        ];
    }

    public function toTelegram($notifiable)
    {
        $url = route('discussion.view', ['id' => $this->discussion->id]);
        return TelegramMessage::create()
            ->to($this->user->telegram_user_id)
            ->content('بحث جدید با عنوان' . $this->discussion->title . 'ایجاد شد.')
            ->button('مشاهده بحث', $url);
    }

    public function toTextMessage($notifiable)
    {
        $url = route('discussion.view', ['id' => $this->discussion->id]);
        return TextMessage::create()
            ->to($this->user->mobile)
            ->content('بحث با عنوان' . $this->discussion->tile . ' ایجاد شد. مشاهده:' . $url);
    }
}
