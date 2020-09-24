<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSalesTransactionListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sales_transaction_list', function (Blueprint $table) {
            $table->id('sales_transaction_list_id');
            $table->string('invoice_no', 50);
            $table->string('barcode_no');
            $table->integer('quantity');
            $table->decimal('selling_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
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
        Schema::dropIfExists('tbl_sales_transaction_list');
    }
}
