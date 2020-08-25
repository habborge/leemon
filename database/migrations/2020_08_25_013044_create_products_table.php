<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('reference');
            $table->string('name', 50);
            $table->string('brand',40);
            //$table->integer('subcategory_id');
            $table->text('description');
            //$table->integer('nature_id');
            $table->integer('quantity');
            $table->string('measure', 10);
            //$table->string('colour', 20);
            $table->decimal('cost',10,2);
            $table->boolean('to_sell');
            $table->decimal('price',10,2);
            $table->text('img1');
            $table->text('img2');
            $table->integer('prom');
            //$table->decimal('price_min',10,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
