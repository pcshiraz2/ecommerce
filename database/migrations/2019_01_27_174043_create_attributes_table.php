<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->bigInteger('category_id');
            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('code')->unique()->nullable();
            $table->longText('description')->nullable();
            $table->longText('options')->nullable();
            $table->bigInteger('order')->nullable();
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
        Schema::dropIfExists('attributes');
    }
}
