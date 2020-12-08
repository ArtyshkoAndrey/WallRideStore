<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DisabledCouponsCategories extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('disabled_coupons_categories', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('coupon_id');
      $table->unsignedBigInteger('category_id');
      $table->foreign('coupon_id')->references('id')->on('coupon_codes')->onDelete('cascade');
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('disabled_coupons_categories');
  }
}
