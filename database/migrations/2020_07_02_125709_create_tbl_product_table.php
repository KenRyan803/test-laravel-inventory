<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product', function (Blueprint $table) {            
            $table->id();
            $table->string('barcode_no');
            $table->string('sku', 100)->default('n/a')->nullable();
            $table->integer('category_no');
            $table->text('product_name');
            $table->string('product_unit', 15);
            $table->string('product_description', 150);
            $table->string('product_photo')->default('product.png')->nullable();
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
        Schema::dropIfExists('tbl_product');
    }
}
