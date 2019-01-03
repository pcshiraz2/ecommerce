<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->longText('text')->nullable();
            $table->enum('access', ['public', 'private'])->default('public');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('pages')->insert([
            'title' => 'نرم افزار شیراز',
            'text' => 'Index',
            'access' => 'public',
        ]);
        DB::table('pages')->insert([
            'title' => 'درباره ما',
            'text' => 'About US',
            'access' => 'public',
        ]);
        DB::table('pages')->insert([
            'title' => 'تماس با ما',
            'text' => 'Contact US',
            'access' => 'public',
        ]);

        DB::table('pages')->insert([
            'title' => 'قوانین و مقررات',
            'text' => 'Law TOS',
            'access' => 'public',
        ]);
        DB::table('pages')->insert([
            'title' => 'ثبت شکایت',
            'text' => 'Complaint',
            'access' => 'public',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
