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

class InvoiceCreated extends Notification
{
    use Queueable;
    public $invoice = null;
    public $user = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice, $user)
    {
        $this->invoice = $invoice;
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
        $url = route('invoice.view-password', [$this->invoice->id, $this->invoice->password]);
        return (new MailMessage)
            ->subject(config('platform.name') . ' - فاکتور شماره:' . $this->invoice->id)
            ->line('مبلغ به عدد:' . \App\Utils\MoneyUtil::format($this->invoice->total))
            ->line('مبلغ به حروف:' . \App\Utils\MoneyUtil::letters($this->invoice->total))
            ->action('مشاهده جزئیات فاکتور', $url);
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
            'title' => "فاکتور شماره " . $this->invoice->id . " با مبلغ " . $this->invoice->total . " صادر شد.",
            'url' => route('invoice.view', [$this->invoice->id]),
        ];
    }

    public function toTelegram($notifiable)
    {
        $pay = route('invoice.pay-link-password', [$this->invoice->id, $this->invoice->password]);
        $view = route('invoice.view-password', [$this->invoice->id, $this->invoice->password]);
        return TelegramMessage::create()
            ->to($this->user->telegram_user_id)
            ->content("صدور فاکتور جدید:" . $this->invoice->id . "\n" . "مبلغ فاکتور:" . number_format($this->invoice->total) . "\n")// Markdown supported.
            ->button('نمایش فاکتور', $view)
            ->button('پرداخت فاکتور', $pay);
    }


    public function toTextMessage($notifiable)
    {
        $url = route('invoice.view-password', [$this->invoice->id, $this->invoice->password]);

        return TextMessage::create()
            ->to($this->user->mobile)
            ->content('صدور فاکتور شماره:' . $this->invoice->id . ' مشاهده:' . $url);
    }


}
