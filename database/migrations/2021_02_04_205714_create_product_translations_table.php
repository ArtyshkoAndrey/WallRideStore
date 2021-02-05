<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('product_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('product_id')
        ->constrained('products')
        ->onDelete('cascade');

      $table->string('locale')
        ->index();

      $table->string('title');
      $table->text('description');

      $table->unique(['product_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('product_translations');
  }
}
