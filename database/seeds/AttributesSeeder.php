<?php

use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attribute = new Attribute();
        $attribute->title = 'برند';
        $attribute->code = 'brand';
        $attribute->category_id = 23;
        $attribute->enabled =  true;
        $attribute->save();

        $attribute = new Attribute();
        $attribute->title = 'مدل';
        $attribute->code = 'model';
        $attribute->category_id = 23;
        $attribute->enabled =  true;
        $attribute->save();
    }
}
