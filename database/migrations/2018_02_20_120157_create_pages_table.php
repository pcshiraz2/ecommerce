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
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->longText('text')->nullable();
            //type: ['public', 'private']
            $table->string('access')->default('public');
            $table->boolean('enabled');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('pages')->insert([
            'title' => 'پی سی شیراز',
            'text' => 'Index',
            'access' => 'public',
            'enabled' => true
        ]);
        DB::table('pages')->insert([
            'title' => 'درباره ما',
            'text' => 'About US',
            'access' => 'public',
            'enabled' => true
        ]);
        DB::table('pages')->insert([
            'title' => 'تماس با ما',
            'text' => 'Contact US',
            'access' => 'public',
            'enabled' => true
        ]);

        DB::table('pages')->insert([
            'title' => 'قوانین و مقررات',
            'text' => 'Law TOS',
            'access' => 'public',
            'enabled' => true
        ]);
        DB::table('pages')->insert([
            'title' => 'ثبت شکایت',
            'text' => 'Complaint',
            'access' => 'public',
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
        Schema::dropIfExists('pages');
    }
}
