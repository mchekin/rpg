<?php

use App\Modules\Equipment\Domain\ItemStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_item', static function (Blueprint $table) {

            $table->smallInteger('inventory_slot_number');

            $table->enum('status', ItemStatus::STATUSES)->default(ItemStatus::IN_BACKPACK);

            $table->uuid('inventory_id')->index();
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');

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
        Schema::dropIfExists('inventory_item');
    }
}
