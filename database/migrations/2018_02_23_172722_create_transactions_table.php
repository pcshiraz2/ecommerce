<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->nullable();
            $table->unsignedBigInteger('gateway_transaction_id')->nullable();
            $table->integer('account_id');
            $table->integer('user_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('currency_code')->default(config('platform.currency'))->nullable();
            $table->double('currency_rate', 15, 8)->nullable();
            $table->decimal('amount', 15, 4);


            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('password')->nullable();
            $table->text('description')->nullable();

            //Status:income,expense,transfer
            $table->string('type');


            $table->timestamp('transaction_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->string('attachment')->nullable();

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
        Schema::dropIfExists('transactions');
    }
}
