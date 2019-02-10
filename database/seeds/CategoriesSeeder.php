<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->id =  1;
        $category->title =  'سخت افزار';
        $category->type =  'Product';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  2;
        $category->title =  'نرم افزار';
        $category->type =  'Product';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  3;
        $category->title =  'خدمات';
        $category->type =  'Product';
        $category->enabled =  true;
        $category->save();

        //Article
        $category = new Category();
        $category->id =  4;
        $category->title =  'عمومی';
        $category->type =  'Article';
        $category->enabled =  true;
        $category->save();


        $category = new Category();
        $category->id =  5;
        $category->title =  'آموزشی';
        $category->type =  'Article';
        $category->enabled =  true;
        $category->save();

        //Ticket
        $category = new Category();
        $category->id =  6;
        $category->title =  'پشتیبانی سایت';
        $category->type =  'Ticket';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  7;
        $category->title =  'خدمات نصب';
        $category->type =  'Ticket';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  8;
        $category->title =  'پیگیری خرید';
        $category->type =  'Ticket';
        $category->enabled =  true;
        $category->save();


        $category = new Category();
        $category->id =  9;
        $category->title =  'ارتباط با مدیریت';
        $category->type =  'Ticket';
        $category->enabled =  true;
        $category->save();


        //Income
        $category = new Category();
        $category->id =  10;
        $category->title =  'فروش';
        $category->type =  'Income';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  11;
        $category->title =  'چک';
        $category->type =  'Income';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  12;
        $category->title =  'اقساط';
        $category->type =  'Income';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  13;
        $category->title =  'انتقال';
        $category->type =  'Income';
        $category->enabled =  true;
        $category->save();


        //Expense
        $category = new Category();
        $category->id =  14;
        $category->title =  'چک';
        $category->type =  'Expense';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  15;
        $category->title =  'اقساط';
        $category->type =  'Expense';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  16;
        $category->title =  'خرید';
        $category->type =  'Expense';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  17;
        $category->title =  'انتقال';
        $category->type =  'Expense';
        $category->enabled =  true;
        $category->save();

        //Settings Category
        $category = new Category();
        $category->id =  18;
        $category->title =  'عمومی';
        $category->type =  'Setting';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  19;
        $category->title =  'پرداخت';
        $category->type =  'Setting';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  20;
        $category->title =  'حسابداری';
        $category->type =  'Setting';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  21;
        $category->title =  'محتوا';
        $category->type =  'Setting';
        $category->enabled =  true;
        $category->save();

        $category = new Category();
        $category->id =  22;
        $category->title =  'فاکتور';
        $category->type =  'Setting';
        $category->enabled =  true;
        $category->save();


        $category = new Category();
        $category->id =  23;
        $category->title =  'مشخصات کلی';
        $category->type =  'Attribute';
        $category->enabled =  true;
        $category->save();


    }
}
