<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('auto_id');
            $table->uuid('id')->index();

            $table->uuid('character_id')->nullable();
            // TODO: refactor character creation to allow creating character record before inventory record
            // $table->foreign('character_id')->references('id')->on('characters')->onDelete('restrict');

            $table->integer('money');

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
        Schema::dropIfExists('inventories');
    }
}
