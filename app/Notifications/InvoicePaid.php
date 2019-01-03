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

class InvoicePaid extends Notification
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
            ->subject('پرداخت فاکتورشماره:' . $this->invoice->id)
            ->line('فاکتور شماره:' . $this->invoice->id . " با مبلغ:" . $this->invoice->total . " پرداخت شد.")
            ->action('مشاهده فاکتور', $url);
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
            'title' => "فاکتور شماره " . $this->invoice->id . " با مبلغ " . $this->invoice->total . "پرداخت شد.",
            'url' => route('invoice.view', [$this->invoice->id]),
        ];
    }

    public function toTelegram($notifiable)
    {
        $url = route('transaction.view', ['id' => $this->transaction->id]);
        return TelegramMessage::create()
            ->to($this->user->telegram_user_id)
            ->content("پرداخت مبلغ:" . $this->transaction->amount)// Markdown supported.
            ->button('نمایش تراکنش', $url);

    }

    public function toTextMessage($notifiable)
    {
        $url = route('transaction.view', ['id' => $this->transaction->id]);
        return TextMessage::create()
            ->to($this->user->mobile)
            ->content('نتیجه تراکنش شماره:' . $this->transaction->id . ' مشاهده:' . $url);
    }
}
