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
      $table->text('name');
      $table->unsignedInteger('express_id');
      $table->foreign('express_id')->references('id')->on('express_companies')->onDelete('cascade');
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
