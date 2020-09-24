<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblStockEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stock_entry', function (Blueprint $table) {
            $table->id('stock_entry_id');
            $table->string('receipt_no', 100);
            $table->string('stock_entry_no', 100);
            $table->integer('supplier_id');
            $table->integer('total_products_added');
            $table->integer('total_stocks_added');
            $table->decimal('total_cost_of_receipt', 10, 2);
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
        Schema::dropIfExists('tbl_stock_entry');
    }
}
