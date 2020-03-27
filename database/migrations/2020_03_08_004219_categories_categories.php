<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('categories_categories', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedBigInteger('category_id');
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        $table->unsignedBigInteger('child_category_id');
        $table->foreign('child_category_id')->references('id')->on('categories')->onDelete('cascade');
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
      Schema::dropIfExists('categories_categories');
    }
}
