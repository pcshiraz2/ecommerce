<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Models\Discussion;

class DiscussionObserver
{
    /**
     * Handle the discussion "created" event.
     *
     * @param  \App\Models\Discussion  $discussion
     * @return void
     */
    public function created(Discussion $discussion)
    {
        Cache::forget('discussions');
        return true;
    }

    /**
     * Handle the discussion "updated" event.
     *
     * @param  \App\Models\Discussion  $discussion
     * @return void
     */
    public function updated(Discussion $discussion)
    {
        Cache::forget('discussions');
        return true;
    }

    /**
     * Handle the discussion "deleted" event.
     *
     * @param  \App\Models\Discussion  $discussion
     * @return void
     */
    public function deleted(Discussion $discussion)
    {
        Cache::forget('discussions');
        return true;
    }

    /**
     * Handle the discussion "restored" event.
     *
     * @param  \App\Models\Discussion  $discussion
     * @return void
     */
    public function restored(Discussion $discussion)
    {
        Cache::forget('discussions');
        return true;
    }

    /**
     * Handle the discussion "force deleted" event.
     *
     * @param  \App\Models\Discussion  $discussion
     * @return void
     */
    public function forceDeleted(Discussion $discussion)
    {
        Cache::forget('discussions');
        return true;
    }
}
