<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('category_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('category_id')
        ->constrained('categories')
        ->onDelete('cascade');

      $table->string('locale')
        ->index();

      $table->string('name');
      $table->unique(['category_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('category_translations');
  }
}
