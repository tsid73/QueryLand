<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ques_table', function (Blueprint $table) {
            $table->increments('ques_id')->unsigned();
            $table->smallInteger('subject_id')->unsigned();
            $table->foreign('subject_id')
            ->references('subject_id')->on('subject_table');
            $table->smallInteger('sub_cat')->unsigned();
            $table->foreign('sub_cat')
            ->references('sub_cat')->on('sub_category');
            $table->string('ques_heading');
            $table->mediumText('ques_content')->nullable();
            $table->string('tags')->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('ques_table');
    }
}
