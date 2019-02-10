<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->string('title');
            $table->longText('text');
            $table->string('slug')->nullable();
            $table->boolean('important')->nullable();
            //Type:['normal', 'done', 'close']
            $table->string('type')->default('normal');
            $table->string('color')->nullable();
            $table->integer('posts')->default(0);
            $table->longText('options')->nullable();
            $table->boolean('enabled')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('discussion_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('discussion_id');
            $table->longText('text');
            $table->longText('options')->nullable();
            $table->boolean('enabled')->default(true);
            $table->boolean('best_answer')->default(false);
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
        Schema::dropIfExists('discussions');
        Schema::dropIfExists('discussion_posts');
    }
}
