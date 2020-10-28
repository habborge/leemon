<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersPurchasesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers_purchases_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('supplier_purchase_id')->index();
            $table->bigInteger('product_id')->index();
            $table->string('lot_id', 50)->index();
            $table->integer('quantity');
            $table->text('description');
            $table->integer('discount');
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
        Schema::dropIfExists('suppliers_purchases_details');
    }
}
