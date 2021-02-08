<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryCategory extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('category_categories', function (Blueprint $table) {
      $table->id();
      $table->foreignId('category_id')
        ->constrained('categories')
        ->onUpdate('cascade')
        ->onDelete('cascade');
      $table->foreignId('child_category_id')
        ->constrained('categories')
        ->onUpdate('cascade')
        ->onDelete('cascade');
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
    Schema::dropIfExists('category_categories');
  }
}
