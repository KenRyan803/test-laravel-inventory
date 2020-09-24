<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblStockEntryList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_stock_entry_list', function (Blueprint $table) {
            $table->id('stock_entry_list_id');
            $table->string('stock_entry_no', 100);
            $table->string('barcode_no');
            $table->string('expiry_date');
            $table->decimal('orig_cost_per', 10, 2);
            $table->decimal('total_whlsale_cost', 10, 2);
            $table->integer('stocks_added');
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
        Schema::dropIfExists('tbl_stock_entry_list');
    }
}
