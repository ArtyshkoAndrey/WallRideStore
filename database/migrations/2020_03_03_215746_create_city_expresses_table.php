<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityExpressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
  {
    Schema::create('city_expresses', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('city_id');
      $table->unsignedInteger('express_zone_id');
      $table->foreign('express_zone_id')->references('id')->on('express_zones')->onDelete('cascade');
      $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
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
        Schema::dropIfExists('city_expresses');
    }
}
