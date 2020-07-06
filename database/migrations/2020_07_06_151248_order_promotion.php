<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderPromotion extends Migration
{
  public function up()
  {
    Schema::create('orders_promotions', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedInteger('order_id');
      $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
      $table->unsignedBigInteger('promotion_id');
      $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
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
    Schema::dropIfExists('orders_promotions');
  }
}
