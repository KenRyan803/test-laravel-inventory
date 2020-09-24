<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSalesTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sales_transaction', function (Blueprint $table) {
            $table->id('sales_transaction_no');
            $table->string('invoice_no', 50);
            $table->integer('admin_id');
            $table->integer('total_quantity');
            $table->decimal('tax', 10, 2);
            $table->decimal('accumulated_total', 10, 2);
            $table->decimal('amount_tendered', 10, 2);
            $table->decimal('change', 10, 2);
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
        Schema::dropIfExists('tbl_sales_transaction');
    }
}
