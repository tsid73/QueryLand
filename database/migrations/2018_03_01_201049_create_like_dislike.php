<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeDislike extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Votes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')->on('user_basic')
            ->onDelete('cascade');
            $table->integer('ans_id')->unsigned();
            $table->foreign('ans_id')
            ->references('ans_id')->on('ans_table')
            ->onDelete('cascade');
            $table->biginteger('up')->unsigned()->nullable()->default(0);
            $table->biginteger('down')->unsigned()->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Votes');
    }
}
