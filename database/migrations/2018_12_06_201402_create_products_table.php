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
            $table->string('slug')->nullable();
            $table->string('code')->nullable();
            $table->bigInteger('category_id');
            $table->bigInteger('brand_id')->nullable();
            $table->string('model')->nullable();
            $table->double('weight')->nullable();
            $table->string('currency_code')->default(config('platform.currency'))->nullable();
            $table->double('currency_rate', 15, 8)->nullable();
            $table->decimal('sale_price', 15, 4);
            $table->decimal('purchase_price', 15, 4)->nullable();
            $table->decimal('period_price', 15, 4)->nullable();
            $table->decimal('discount_price', 15, 4)->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->double('initial_balance')->default(0)->nullable();
            $table->double('asset_balance')->default(0)->nullable();
            $table->double('period')->default(0)->nullable();
            $table->string('factory')->nullable();

            $table->text('description')->nullable();
            $table->longText('text')->nullable();
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();

            $table->boolean('shop');
            $table->boolean('asset');
            $table->boolean('post');
            $table->boolean('top');
            $table->boolean('discount');
            $table->boolean('call_price');

            $table->decimal('tax', 15, 4)->nullable();
            $table->bigInteger('order')->nullable();
            $table->longText('options')->nullable();
            $table->boolean('enabled');

            $table->timestamp('discount_expire_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_files', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('product_id');
            $table->string('title');
            $table->string('name');
            $table->string('source');
            $table->bigInteger('size');
            $table->text('description')->nullable();
            $table->boolean('free');
            $table->boolean('public');
            $table->bigInteger('order')->nullable();
            $table->boolean('enabled');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('product_id');
            $table->string('title');
            $table->string('source');
            $table->text('description')->nullable();
            $table->boolean('enabled');
            $table->bigInteger('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('product_id');
            $table->bigInteger('user_id');
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->boolean('enabled');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('product_id');
            $table->bigInteger('attribute_id');
            $table->text('value')->nullable();
            $table->bigInteger('order')->nullable();
            $table->longText('options')->nullable();
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_files');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_comments');
        Schema::dropIfExists('product_attributes');
    }
}
