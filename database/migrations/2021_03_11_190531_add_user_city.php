<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserCity extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->foreignId('country_id')
        ->nullable()
        ->constrained()
        ->onUpdate('cascade')
        ->onDelete('set null');

      $table->foreignId('city_id')
        ->nullable()
        ->constrained()
        ->onUpdate('cascade')
        ->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->removeColumn('city_id');
      $table->removeColumn('country_id');
    });
  }
}
