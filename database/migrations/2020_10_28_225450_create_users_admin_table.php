<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_admin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('fullname');
            $table->string('email', 100)->unique();
            
            $table->string('password');
            $table->integer('nivel_acceso');
            $table->string('api_token', 100);
            $table->integer('state');
            $table->rememberToken();
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
        Schema::dropIfExists('users_admin');
    }
}
