<?php

use App\Models\ItemPrototype;
use App\Modules\Equipment\Application\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Domain\ItemEffect;
use App\Modules\Equipment\Domain\ItemType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     * @throws Exception
     */
    public function up()
    {
        Schema::create('item_prototypes', static function (Blueprint $table) {
            $table->bigIncrements('auto_id');
            $table->uuid('id')->index();

            $table->string('name');
            $table->string('description');

            $table->json('effects');

            $table->integer('price')->default(0);

            $table->string('image_file_path');

            $table->enum('type', ItemType::TYPES)->default(ItemType::MISCELLANEOUS);

            $table->timestamps();
        });

        Schema::create('items', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('description');

            $table->json('effects');

            $table->integer('price')->default(0);

            $table->string('image_file_path');

            $table->enum('type', ItemType::TYPES)->default(ItemType::MISCELLANEOUS);

            $table->uuid('prototype_id');
            $table->foreign('prototype_id')->references('id')->on('item_prototypes')->onDelete('restrict');

            $table->uuid('creator_character_id');
            $table->foreign('creator_character_id')->references('id')->on('characters')->onDelete('restrict');

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

    /**
     * @return CreateItemsTable
     * @throws Exception
     */
    private function createPrototypes(): self
    {
        DB::table('item_prototypes')->delete();

        /** @var ItemPrototypeRepositoryInterface $itemPrototypeRepository */
        $itemPrototypeRepository = resolve(ItemPrototypeRepositoryInterface::class);

        $prototypes = [
            [
                'id' => $itemPrototypeRepository->nextIdentity()->toString(),
                'name' => 'Wooden Club',
                'description' => 'Simplest weapon. A crude wooden club made from a peace of wood.',
                'effects' => [
                    [
                        'quantity' => 1,
                        'type' => ItemEffect::DAMAGE,
                    ]
                ],
                'price' => 15,
                'type' => ItemType::MAIN_HAND,
                'image_file_path' => 'images/equipment/main_hand/1club.png',
            ],
            [
                'id' => $itemPrototypeRepository->nextIdentity()->toString(),
                'name' => 'Reinforced Club',
                'description' => 'A wooden club reinforced with metal.',
                'effects' => [
                    [
                        'quantity' => 3,
                        'type' => ItemEffect::DAMAGE,
                    ]
                ],
                'price' => 500,
                'type' => ItemType::MAIN_HAND,
                'image_file_path' => 'images/equipment/main_hand/2reinforced_club.png',
            ],
            [
                'id' => $itemPrototypeRepository->nextIdentity()->toString(),
                'name' => 'Wooden Buckler',
                'description' => 'A small wooden shield.',
                'effects' => [
                    [
                        'quantity' => 2,
                        'type' => ItemEffect::ARMOR,
                    ]
                ],
                'price' => 20,
                'type' => ItemType::OFF_HAND,
                'image_file_path' => 'images/equipment/off_hand/buckler.png',
            ],
            [
                'id' => $itemPrototypeRepository->nextIdentity()->toString(),
                'name' => 'Linen Shirt',
                'description' => 'A simple shirt made of linen.',
                'effects' => [
                    [
                        'quantity' => 1,
                        'type' => ItemEffect::ARMOR,
                    ]
                ],
                'price' => 5,
                'type' => ItemType::BODY_ARMOR,
                'image_file_path' => 'images/equipment/body_armor/linen_shirt.png',
            ],
            [
                'id' => $itemPrototypeRepository->nextIdentity()->toString(),
                'name' => 'Closed Steel Helmet',
                'description' => 'Closed helmet made of steel plates',
                'effects' => [
                    [
                        'quantity' => 10,
                        'type' => ItemEffect::ARMOR,
                    ]
                ],
                'price' => 1000,
                'type' => ItemType::HEAD_GEAR,
                'image_file_path' => 'images/equipment/head_gear/closed_steel_helmet.png',
            ],
        ];

        foreach ($prototypes as $prototype) {
            ItemPrototype::query()->create($prototype);
        }

        return $this;
    }
}
