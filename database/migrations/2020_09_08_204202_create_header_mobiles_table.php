<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderMobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_mobiles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('photo')->nullable();
            $table->text('url');
            $table->text('h1');
            $table->text('h2');
            $table->text('btn_text');
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
        Schema::dropIfExists('header_mobiles');
    }
}
