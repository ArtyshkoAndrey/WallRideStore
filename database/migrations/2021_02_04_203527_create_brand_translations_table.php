<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('brand_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('brand_id')
        ->constrained('brands')
        ->onDelete('cascade');

      $table->string('locale')
        ->index();

      $table->string('name');
      $table->unique(['brand_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('brand_translations', function (Blueprint $table) {
      //
    });
  }
}
