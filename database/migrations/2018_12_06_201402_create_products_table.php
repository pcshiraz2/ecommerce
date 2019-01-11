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

            $table->decimal('sale_price', 15, 4);
            $table->decimal('purchase_price', 15, 4);
            $table->decimal('renewal_price', 15, 4);
            $table->decimal('off_price', 15, 4);
            $table->integer('category_id');
            $table->integer('user_id');

            $table->double('initial_balance')->nullable();
            $table->double('period')->nullable();
            $table->string('factory')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->longText('text')->nullable();
            $table->boolean('enabled');
            $table->boolean('shop');
            $table->boolean('asset');
            $table->boolean('post');
            $table->boolean('renewal');
            $table->boolean('top');

            $table->integer('order')->nullable();
            $table->text('options')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('title');
            $table->string('name');
            $table->string('source');

            $table->text('description')->nullable();
            $table->boolean('enabled');
            $table->boolean('free');
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('title');
            $table->string('source');
            $table->text('description')->nullable();
            $table->boolean('enabled');
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //Only Digital Goods
        Schema::create('product_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->integer('product_id');
            $table->integer('user_id');
            $table->string('serial_number')->nullable();
            $table->boolean('enabled');
            $table->text('options')->nullable();
            $table->timestamp('expire_at');
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
