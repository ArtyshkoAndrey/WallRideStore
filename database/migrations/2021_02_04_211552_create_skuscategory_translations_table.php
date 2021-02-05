<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkuscategoryTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('skuscategory_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('skuscategory_id')
        ->constrained('skuscategories')
        ->onDelete('cascade');

      $table->string('locale')
        ->index();

      $table->string('name');
      $table->unique(['skuscategory_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('skuscategory_translations');
  }
}
