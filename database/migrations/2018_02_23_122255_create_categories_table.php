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
            $table->string('slug')->nullable();
            $table->string('order')->nullable();
            $table->integer('category_id')->nullable();
            $table->boolean('enabled');
            $table->boolean('visible')->nullable();
            $table->longText('options')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
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
