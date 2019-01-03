<?php
/**
 * Created by PhpStorm.
 * User: Ali Ghasemzadeh
 * Date: 3/30/2018
 * Time: 5:05 PM
 */

namespace App\Channels;

use App\Channels\ShortMessage;
use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;

class TextMessageChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toTextMessage($notifiable);
        $client = new Client();
        $response = $client->request('POST', 'https://api.sabanovin.com/v1/' . config('textmessage.api-key') . '/sms/send.json', [
            'form_params' => [
                'gateway' => config('textmessage.gateway'),
                'to' => $message->payload['mobile'],
                'text' => $message->payload['text']
            ]
        ]);
    }
}