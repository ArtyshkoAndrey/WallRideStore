<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddShortContentPostTranslation extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('post_translations', function (Blueprint $table) {
      $table->string('short_content');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('post_translations', function (Blueprint $table) {
      $table->removeColumn('short_content');
    });
  }
}
