<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModalsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::create('modals', function (Blueprint $table) {
      $table->id();
      $table->integer('type');
      $table->text('image')->nullable();
      $table->text('link')->nullable();
      $table->boolean('status')->default(1);
      $table->boolean('on_auth')->default(0);
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
    Schema::dropIfExists('modals');
  }
}
