<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuesExtra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ques_extra', function (Blueprint $table) {
            $table->integer('ques_id')->unsigned();
            $table->foreign('ques_id')
            ->references('ques_id')->on('ques_table')
            ->onDelete('cascade');
            $table->biginteger('ques_views')->unsigned()->default(0);
            $table->string('num_of_ans',3)->default('0');
            $table->string('best',1)->nullable();
            $table->string('status',1)->default('0');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ques_extra');
    }
}
