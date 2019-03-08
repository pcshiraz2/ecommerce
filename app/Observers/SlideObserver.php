<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Models\Slide;


class SlideObserver
{
    /**
     * Handle the slide "created" event.
     *
     * @param  \App\Models\Slide  $slide
     * @return void
     */
    public function created(Slide $slide)
    {
        Cache::forget('slides');
        return true;
    }

    /**
     * Handle the slide "updated" event.
     *
     * @param  \App\Models\Slide  $slide
     * @return void
     */
    public function updated(Slide $slide)
    {
        Cache::forget('slides');
        return true;
    }

    /**
     * Handle the slide "deleted" event.
     *
     * @param  \App\Models\Slide  $slide
     * @return void
     */
    public function deleted(Slide $slide)
    {
        Cache::forget('slides');
        return true;
    }

    /**
     * Handle the slide "restored" event.
     *
     * @param  \App\Models\Slide  $slide
     * @return void
     */
    public function restored(Slide $slide)
    {
        Cache::forget('slides');
        return true;
    }

    /**
     * Handle the slide "force deleted" event.
     *
     * @param  \App\Models\Slide  $slide
     * @return void
     */
    public function forceDeleted(Slide $slide)
    {
        Cache::forget('slides');
        return true;
    }
}
