<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
            $table->integer('park_id')->index();
            $table->integer('supplier_id')->index();
            $table->date('ordered_at')->nullable();
            $table->string('park_reference', 50)->index();
            $table->string('reference', 50);
            $table->decimal('cost_price')->nullable();
            $table->decimal('selling_price')->nullable();
            $table->decimal('vat')->nullable();
            $table->string('internal_invoice_id', 50)->nullable();
            $table->string('external_invoice_id', 50)->nullable();
            $table->date('invoiced_at')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
