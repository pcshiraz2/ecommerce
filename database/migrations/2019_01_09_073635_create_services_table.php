<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('domain')->nullable();
            $table->string('ip', 20)->nullable();
            $table->string('serial_number')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            //status:paid,suspned,terminate,active,pendding
            $table->string('status');
            $table->longText('options')->nullable();
            $table->boolean('enabled');
            $table->timestamp('expire_at')->nullable();
            $table->timestamp('suspend_at')->nullable();
            $table->timestamp('renew_at')->nullable();
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
        Schema::dropIfExists('services');
    }
}
