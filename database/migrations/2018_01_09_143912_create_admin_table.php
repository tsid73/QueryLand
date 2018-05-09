<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_table', function (Blueprint $table) {
            $table->increments('admin_id');
            $table->string('username')->unique();
            $table->string('password');
            $table->dateTime('last_login')->nullable();
            $table->mediumtext('admin_pic')->nullable();
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('admin_table');
    }
}
