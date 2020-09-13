<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_item', static function (Blueprint $table) {

            $table->smallInteger('inventory_slot_number');

            $table->integer('price')->default(0);

            $table->uuid('store_id')->index();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');

            $table->uuid('item_id')->index();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');

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
        Schema::dropIfExists('store_item');
    }
}
