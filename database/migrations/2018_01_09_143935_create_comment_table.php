<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_table', function (Blueprint $table) {
            $table->increments('comment_id')->unsigned();
            $table->integer('ques_id')->unsigned();
            $table->foreign('ques_id')
            ->references('ques_id')->on('ques_table')
            ->onDelete('cascade');
            $table->integer('ans_id')->unsigned();
            $table->foreign('ans_id')
            ->references('ans_id')->on('ans_table')
            ->onDelete('cascade');
            $table->Text('comment_body');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')->on('user_basic')
            ->onDelete('cascade');
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
        Schema::dropIfExists('comment_table');
    }
}
