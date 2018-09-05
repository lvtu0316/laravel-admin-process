<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('number');
            $table->string('version');
            $table->integer('project_id');
            $table->text('conf')->nullable;
            $table->string('ip');
            $table->string('position');
            $table->timestamp('product_date')->nullable();
            $table->integer('type_id');
            $table->integer('category_id');
            $table->integer('system_id');
            $table->integer('address_id');
            $table->integer('person_id');
            $table->timestamp('put_time')->nullable();
            $table->integer('user_id');
            $table->string('card_number')->nullable();
            $table->integer('count');
            $table->float('price');
            $table->float('total');
            $table->float('depreciation');
            $table->float('worth');
            $table->integer('action_id');
            $table->integer('rate');
            $table->integer('years');
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
        Schema::dropIfExists('assets');
    }
}
