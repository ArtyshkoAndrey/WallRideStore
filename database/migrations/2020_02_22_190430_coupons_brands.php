<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CouponsBrands extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('coupons_brands', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('coupon_id');
      $table->unsignedBigInteger('brand_id');
      $table->foreign('coupon_id')->references('id')->on('coupon_codes')->onDelete('cascade');
      $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('coupons_brands');
  }
}
