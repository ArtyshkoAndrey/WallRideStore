<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('faqs_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('faqs_id')
        ->constrained('faqs')
        ->onDelete('cascade');

      $table->string('locale')
        ->index();

      $table->string('title');
      $table->text('content');
      $table->unique(['faqs_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('faqs_translations');
  }
}
