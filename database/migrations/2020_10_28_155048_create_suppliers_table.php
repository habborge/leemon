<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('person_type', ['Natural', 'Juridica']);
            $table->string('name',50);
            $table->string('provider',50);
            $table->string('n_doc',50);
            
            $table->string('address',100);
            $table->string('phone',30);
            $table->string('fax',30);
            $table->string('contact',50);
            $table->integer('country_id');
            $table->integer('state')->index();
            $table->string('city',30);
            $table->string('email',60)->unique();
            $table->integer('rut')->unique();
            $table->text('web');
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
        Schema::dropIfExists('suppliers');
    }
}
