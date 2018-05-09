<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnsExtra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ans_extra', function (Blueprint $table) {
            $table->integer('ans_id')->unsigned();
            $table->foreign('ans_id')
            ->references('ans_id')->on('ans_table')
            ->onDelete('cascade');
            $table->string('num_of_comments',3)->default('0');
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
        Schema::dropIfExists('ans_extra');
    }
}
