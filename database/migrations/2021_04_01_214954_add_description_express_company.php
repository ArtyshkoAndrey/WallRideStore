<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionExpressCompany extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::table('express_companies', function (Blueprint $table) {
      $table->string('description')
        ->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::table('express_companies', function (Blueprint $table) {
      $table->removeColumn('express_companies');
    });
  }
}
