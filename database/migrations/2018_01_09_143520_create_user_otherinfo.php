<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOtherinfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('user_other', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')            
              ->references('user_id')->on('user_basic')
              ->onDelete('cascade');    
            $table->string('user_xp',4)->default('0');
            $table->string('user_level',2)->default('1');
            /* pic me default pic dalni hai*/
            $table->string('institute')->nullable();
            $table->string('specialisation')->nullable();
            $table->text('topics')->nullable();
            $table->dateTime('last_login')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_other');
    }
}
