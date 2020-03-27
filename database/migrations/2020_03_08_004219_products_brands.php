<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('products_brands', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('product_id');
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        $table->unsignedBigInteger('brand_id');
        $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
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
      Schema::dropIfExists('products_brand');
    }
}
