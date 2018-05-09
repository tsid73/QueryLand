<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ans_table', function (Blueprint $table) {
            $table->increments('ans_id')->unsigned();
            $table->integer('ques_id')->unsigned();
            $table->foreign('ques_id')
            ->references('ques_id')->on('ques_table')
            ->onDelete('cascade');
            $table->mediumText('ans_content');
            $table->string('tags')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')->on('user_basic')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ans_table');
    }
}
