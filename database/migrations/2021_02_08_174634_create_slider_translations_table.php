<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('slider_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('slider_id')
        ->constrained('sliders')
        ->onDelete('cascade');

      $table->string('locale')
        ->index();

      $table->string('h1');
      $table->string('h2');
      $table->string('btn_text');
      $table->unique(['slider_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('slider_translations');
  }
}
