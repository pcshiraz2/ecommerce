<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('type');
            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('code')->nullable();
            $table->boolean('enabled');
            $table->longText('options')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //Product
        DB::table('categories')->insert([
            'id' => 1,
            'title' => 'خدمات',
            'type' => 'Product',
            'enabled' => true
        ]);
        DB::table('categories')->insert([
            'id' => 2,
            'title' => 'نرم افزار',
            'type' => 'Product',
            'enabled' => true
        ]);
        DB::table('categories')->insert([
            'id' => 3,
            'title' => 'سخت افزار',
            'type' => 'Product',
            'enabled' => true
        ]);

        //Article
        DB::table('categories')->insert([
            'id' => 4,
            'title' => 'عمومی',
            'type' => 'Article',
            'enabled' => true
        ]);
        DB::table('categories')->insert([
            'id' => 5,
            'title' => 'آموزشی',
            'type' => 'Article',
            'enabled' => true
        ]);

        //Ticket
        DB::table('categories')->insert([
            'id' => 6,
            'title' => 'پشتیبانی',
            'type' => 'Ticket',
            'enabled' => true
        ]);
        DB::table('categories')->insert([
            'id' => 7,
            'title' => 'خدمات نصب',
            'type' => 'Ticket',
            'enabled' => true
        ]);


        //Income
        DB::table('categories')->insert([
            'id' => 8,
            'title' => 'فروش',
            'type' => 'Income',
            'enabled' => true
        ]);
        DB::table('categories')->insert([
            'id' => 9,
            'title' => 'چک',
            'type' => 'Income',
            'enabled' => true
        ]);
        DB::table('categories')->insert([
            'id' => 10,
            'title' => 'اقساط',
            'type' => 'Income',
            'enabled' => true
        ]);

        DB::table('categories')->insert([
            'id' => 11,
            'title' => 'انتقال',
            'type' => 'Income',
            'enabled' => true
        ]);


        //Expense
        DB::table('categories')->insert([
            'id' => 12,
            'title' => 'چک',
            'type' => 'Expense',
            'enabled' => true
        ]);
        DB::table('categories')->insert([
            'id' => 13,
            'title' => 'اقساط',
            'type' => 'Expense',
            'enabled' => true
        ]);
        DB::table('categories')->insert([
            'id' => 14,
            'title' => 'خرید',
            'type' => 'Expense',
            'enabled' => true
        ]);

        DB::table('categories')->insert([
            'id' => 15,
            'title' => 'انتقال',
            'type' => 'Expense',
            'enabled' => true
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
