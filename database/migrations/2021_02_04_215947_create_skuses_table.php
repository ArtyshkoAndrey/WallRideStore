<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkusesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('skuses', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->integer('weight');
      $table->foreignId('skuscategory_id')
        ->constrained('skuscategories')
        ->onUpdate('cascade')
        ->onDelete('cascade');;
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
    Schema::dropIfExists('skuses');
  }
}
