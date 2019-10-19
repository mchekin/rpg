<?php

use App\ItemPrototype;
use App\Modules\Equipment\Domain\ValueObjects\ItemEffect;
use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use App\Traits\GeneratesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    use GeneratesUuid;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_prototypes', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string("name");
            $table->string("description");

            $table->json('effects');

            $table->string('image_file_path');

            $table->enum('type', ItemType::TYPES)->default(ItemType::MISCELLANEOUS);

            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string("name");
            $table->string("description");

            $table->json('effects');

            $table->string('image_file_path');

            $table->smallInteger('inventory_slot_number');
            $table->boolean('equipped')->default(false);

            $table->enum('type', ItemType::TYPES)->default(ItemType::MISCELLANEOUS);

            $table->uuid('prototype_id');
            $table->foreign('prototype_id')->references('id')->on('item_prototypes')->onDelete('restrict');

            $table->uuid('creator_character_id');
            $table->foreign('creator_character_id')->references('id')->on('characters')->onDelete('restrict');

            $table->uuid('owner_character_id');
            $table->foreign('owner_character_id')->references('id')->on('characters')->onDelete('restrict');

            $table->timestamps();
        });

        $this->createPrototypes();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_prototypes');
    }

    private function createPrototypes(): self
    {
        DB::table('item_prototypes')->delete();

        $prototypes = [
            [
                "id" => $this->generateUuid(),
                "name" => "Wooden Club",
                "description" => "Simplest weapon. A crude wooden club made from a peace of wood.",
                "effects" => [
                    [
                        'quantity' => 1,
                        'type' => ItemEffect::DAMAGE,
                    ]
                ],
                "type" => ItemType::MAIN_HAND,
                "image_file_path" => 'images\equipment\main_hand\1club.png',
            ],
            [
                "id" => $this->generateUuid(),
                "name" => "Reinforced Club",
                "description" => "A wooden club reinforced with metal.",
                "effects" => [
                    [
                        'quantity' => 3,
                        'type' => ItemEffect::DAMAGE,
                    ]
                ],
                "type" => ItemType::MAIN_HAND,
                "image_file_path" => 'images\equipment\main_hand\2reinforced_club.png',
            ],
            [
                "id" => $this->generateUuid(),
                "name" => "Wooden Buckler",
                "description" => "A small wooden shield.",
                "effects" => [
                    [
                        'quantity' => 2,
                        'type' => ItemEffect::ARMOR,
                    ]
                ],
                "type" => ItemType::OFF_HAND,
                "image_file_path" => 'images\equipment\off_hand\buckler.png',
            ],
        ];

        foreach ($prototypes as $prototype) {
            ItemPrototype::query()->create($prototype);
        }

        return $this;
    }
}