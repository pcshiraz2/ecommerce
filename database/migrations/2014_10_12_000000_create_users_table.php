<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name');
            $table->string('title')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique();
            $table->string('economical_number')->nullable();
            $table->string('currency_code')->default(config('platform.currency'))->nullable();
            $table->decimal('credit', 15, 4)->default(0)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('password');
            $table->text('note')->nullable();

            //Other Information
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('national_code')->unique()->nullable();
            $table->string('birth_certificate_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address')->nullable();
            $table->text('location')->nullable();
            $table->timestamp('birth_at')->nullable();

            $table->bigInteger('province_id')->nullable();
            $table->bigInteger('city_id')->nullable();

            //For Log who register and who login
            $table->ipAddress('register_ip')->nullable();
            $table->ipAddress('last_ip')->nullable();

            //For Disable and Enable
            $table->boolean('enabled');

            //For custom fields
            $table->longText('options')->nullable();


            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->string('phone')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address')->nullable();
            $table->text('location')->nullable();
            $table->bigInteger('province_id')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->text('note')->nullable();
            $table->boolean('enabled');
            $table->longText('options')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->string('code');
            $table->text('value')->nullable();
            $table->longText('options')->nullable();
            $table->boolean('enabled');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('users')->insert([
            'first_name' => 'علی',
            'last_name' => 'قاسم زاده',
            'email' => 'it.ghasemzadeh@gmail.com',
            'mobile' => '09177886099',
            'title' => 'مدیر پی سی شیراز',
            'enabled' => 1,
            'password' => Hash::make('p@ssw0rd'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_addresses');
        Schema::dropIfExists('user_attributes');
    }
}
