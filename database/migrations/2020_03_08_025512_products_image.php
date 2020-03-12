<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('products_image', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('product_id')->nullable();
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        $table->text('name');
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
      Schema::dropIfExists('products_image');
    }
}
