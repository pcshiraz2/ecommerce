<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        Cache::forget('topProducts');
        Cache::forget('newProducts');
        Cache::forget('discountProducts');
        return true;
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        Cache::forget('topProducts');
        Cache::forget('newProducts');
        Cache::forget('discountProducts');
        return true;
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        Cache::forget('topProducts');
        Cache::forget('newProducts');
        Cache::forget('discountProducts');
        return true;
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        Cache::forget('topProducts');
        Cache::forget('newProducts');
        Cache::forget('discountProducts');
        return true;
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        Cache::forget('topProducts');
        Cache::forget('newProducts');
        Cache::forget('discountProducts');
        return true;
    }
}
