<?php

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency = new Currency();
        $currency->title = 'ریال';
        $currency->code = 'IRR';
        $currency->rate = 1;
        $currency->enabled =  true;
        $currency->save();
    }
}
