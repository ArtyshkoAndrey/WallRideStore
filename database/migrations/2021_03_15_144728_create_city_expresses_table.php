<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityExpressesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::create('city_expresses', function (Blueprint $table) {
      $table->id();
      $table->foreignId('express_zone_id')
        ->constrained('express_zones')
        ->onDelete('cascade')
        ->onUpdate('cascade');

      $table->foreignId('city_id')
        ->constrained('cities')
        ->onDelete('cascade')
        ->onUpdate('cascade');

      $table->foreignId('express_company_id')
        ->constrained('express_companies')
        ->onDelete('cascade')
        ->onUpdate('cascade');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::dropIfExists('city_expresses');
  }
}
