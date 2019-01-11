<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('text');
            $table->string('source')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->integer('category_id');
            $table->integer('user_id')->nullable();
            $table->boolean('enabled');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('article_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('user_id');
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->boolean('enabled');
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
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_comments');
    }
}
