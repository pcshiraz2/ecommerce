<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('image');

            $table->decimal('price', 15, 0);
            $table->integer('category_id');
            $table->integer('user_id');

            $table->double('initial_balance')->nullable();
            $table->double('period')->nullable();
            $table->string('factory')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->longText('text')->nullable();
            $table->enum('enable', ['yes', 'no'])->default('yes');
            $table->enum('shop', ['yes', 'no'])->default('yes');
            $table->enum('asset', ['yes', 'no'])->default('yes');
            $table->enum('post', ['yes', 'no'])->default('no');
            $table->enum('renewal', ['yes', 'no'])->default('no');
            $table->enum('top', ['yes', 'no'])->default('no');
            $table->integer('order')->nullable();
            $table->text('options')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('name');
            $table->string('source');
            $table->integer('product_id');
            $table->text('description')->nullable();
            $table->enum('enable', ['yes', 'no'])->default('yes');
            $table->enum('free', ['yes', 'no'])->default('yes');
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('source');
            $table->text('description')->nullable();
            $table->integer('product_id');
            $table->enum('enable', ['yes', 'no'])->default('yes');
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //Only Digital Goods
        Schema::create('product_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('factory');
            $table->string('status');
            $table->integer('product_id');
            $table->integer('record_id');
            $table->integer('user_id');
            $table->timestamp('expire_at');
            $table->string('serial_number')->nullable();
            $table->text('options')->nullable();
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_files');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_purchases');
    }
}
