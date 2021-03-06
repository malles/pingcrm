<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->index();
            $table->integer('product_id')->index();
            $table->integer('quantity');
            $table->string('name', 100);
            $table->string('park_reference', 100);
            $table->string('supplier_reference', 100);
            $table->decimal('cost_price')->nullable();
            $table->decimal('selling_price')->nullable();
            $table->decimal('vat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
