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
            $table->bigIncrements('id');
            $table->integer('reference')->unique();
            $table->string('name', 50)->index();
            $table->string('brand',40)->index();
            $table->integer('subcategory_id')->index();
            $table->string('made_by', 40)->index();
            $table->string('sold_by', 40)->index();
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
            $table->integer('prom')->index();
            $table->decimal('delivery_cost',10,2);
            $table->string('health_register', 50)->index();
            $table->integer('restrictions')->index();
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
