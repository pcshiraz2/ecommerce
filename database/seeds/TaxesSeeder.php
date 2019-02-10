<?php

use Illuminate\Database\Seeder;
use App\Models\Tax;

class TaxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tax = new Tax();
        $tax->title = 'ارزش افزوده';
        $tax->rate =  0.09;
        $tax->enabled =  true;
        $tax->save();
    }
}
