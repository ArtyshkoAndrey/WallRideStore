<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title');
      $table->text('description');
      $table->boolean('on_sale')->default(true);
      $table->boolean('on_new')->default(true);
      $table->unsignedInteger('sold_count')->default(0);
      $table->decimal('price', 10, 0);
      $table->decimal('price_sale', 10, 0)->nullable();
      $table->decimal('weight', 10, 2);
      $table->json('meta')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('products', function (Blueprint $table) {

        $table->dropSoftDeletes(); //add this line
      });
    }
}
