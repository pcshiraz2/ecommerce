<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->bigInteger('order')->nullable();
            $table->string('currency_code')->default(config('platform.currency'))->nullable();
            $table->decimal('initial_balance', 15, 4)->nullable();
            $table->decimal('balance', 15, 4)->nullable();
            $table->boolean('enabled');
            $table->longText('options')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('accounts')->insert([
            'title' => 'نقدی',
            'currency_code' => config('platform.currency'),
            'enabled' => true
        ]);
        DB::table('accounts')->insert([
            'title' => 'بانکی',
            'currency_code' => config('platform.currency'),
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
        Schema::dropIfExists('accounts');
    }
}
