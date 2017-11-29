<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('start');
            $table->timestamp('end');
            $table->unsignedInteger('user_id');
            $table->string('comment');
            $table->string('category', 100);
            $table->float('total', 6, 2);
            $table->foreign('user_id')->references('id')->on('users');
            $table->index(['user_id', 'start', 'category']);
            $table->index(['user_id', 'category']);
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
