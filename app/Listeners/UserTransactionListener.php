<?php

namespace App\Listeners;

use App\Events\Event;
use App\Events\UserTransaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserTransactionListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(UserTransaction $event)
    {
        Log::info('=== TestEventListener  ========');
    }
}
