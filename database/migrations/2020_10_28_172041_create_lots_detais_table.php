<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotsDetaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots_detais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lot_id', 50)->index();
            $table->string('lot_code', 50)->index();
            $table->bigInteger('product_id')->index();
            $table->bigInteger('product_lot_serial')->index();
            $table->integer('status'); // product is in stock or was delivery
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
        Schema::dropIfExists('lots_detais');
    }
}
