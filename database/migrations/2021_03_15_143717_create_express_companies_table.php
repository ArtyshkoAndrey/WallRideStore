<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpressCompaniesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::create('express_companies', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->boolean('enabled')->default(true);
      $table->string('track_url')->default(null)->nullable();
      $table->integer('min_cost')->default(0);
      $table->boolean('enabled_cash')->default(true);
      $table->boolean('enabled_card')->default(true);
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
    Schema::dropIfExists('express_companies');
  }
}
