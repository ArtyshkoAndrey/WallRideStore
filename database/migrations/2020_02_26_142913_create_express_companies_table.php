<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('express_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('enabled')->default(1);
            $table->string('cost_type')->default('Настраиваемая');
            $table->decimal('cost', 10, 0)->nullable();
            $table->double('step', 10, 2)->nullable();
            $table->decimal('cost_step', 10, 0);
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
        Schema::dropIfExists('express_companies');
    }
}
