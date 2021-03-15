<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpressZonesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::create('express_zones', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->foreignId('company_id')
        ->constrained('express_companies')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->integer('cost')->nullable();
      $table->integer('cost_step')->nullable();
      $table->integer('step')->nullable();
      $table->json('step_cost_array')->nullable();
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
    Schema::dropIfExists('express_zones');
  }
}
