<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProductInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product_info', function (Blueprint $table) {
            $table->id();
            $table->string('barcode_no');
            $table->decimal('original_price', 10, 2);
            $table->decimal('markup_price_php', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->decimal('discount_php', 10, 2);
            $table->string('status', 20);
            $table->string('stock_entry_no', 100);
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
        Schema::dropIfExists('tbl_product_info');
    }
}
