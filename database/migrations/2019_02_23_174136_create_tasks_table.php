<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('priority')->default('normal');
            $table->integer('user_id')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('finish_at')->nullable();
            $table->integer('order')->nullable();
            $table->string('color')->nullable();
            $table->string('status')->default('open');
            $table->boolean('enabled');
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
        Schema::dropIfExists('tasks');
    }
}
