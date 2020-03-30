<?php

use App\Modules\Trade\Domain\StoreType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->enum('type', StoreType::TYPES)->default(StoreType::SELL_ONLY);

            $table->uuid('character_id')->nullable();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('restrict');

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
        Schema::dropIfExists('stores');
    }
}
