<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModalTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::create('modal_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('modal_id')
        ->constrained('modals')
        ->onDelete('cascade');

      $table->string('locale')
        ->index();

      $table->text('title');
      $table->text('description')->nullable();
      $table->text('text_to_link')->nullable();

      $table->unique(['modal_id', 'locale']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::dropIfExists('modal_translations');
  }
}
