<?php

namespace App\Providers;

use App\Modules\Battle\Application\Contracts\BattleRepositoryInterface;
use App\Modules\Battle\Infrastructure\Repositories\BattleRepository;
use App\Modules\Character\Application\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Application\Contracts\LocationRepositoryInterface;
use App\Modules\Character\Application\Contracts\RaceRepositoryInterface;
use App\Modules\Character\Infrastructure\Repositories\CharacterRepository;
use App\Modules\Character\Infrastructure\Repositories\LocationRepository;
use App\Modules\Equipment\Application\Contracts\InventoryRepositoryInterface;
use App\Modules\Equipment\Application\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Application\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Infrastructure\Repositories\InventoryRepository;
use App\Modules\Equipment\Infrastructure\Repositories\ItemPrototypeRepository;
use App\Modules\Equipment\Infrastructure\Repositories\ItemRepository;
use App\Modules\Image\Application\Contracts\ImageRepositoryInterface;
use App\Modules\Image\Infrastructure\Repositories\ImageRepository;
use App\Modules\Character\Infrastructure\Repositories\RaceRepository;
use App\Modules\Message\Application\Contracts\MessageRepositoryInterface;
use App\Modules\Message\Infrastructure\Repositories\MessageRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositoryInterfaces();
    }

    protected function registerRepositoryInterfaces(): self
    {
        $this->app->bind(
            InventoryRepositoryInterface::class,
            InventoryRepository::class
        );

        $this->app->bind(
            LocationRepositoryInterface::class,
            LocationRepository::class
        );

        $this->app->bind(
            RaceRepositoryInterface::class,
            RaceRepository::class
        );

        $this->app->bind(
            CharacterRepositoryInterface::class,
            CharacterRepository::class
        );

        $this->app->bind(
            ItemPrototypeRepositoryInterface::class,
            ItemPrototypeRepository::class
        );

        $this->app->bind(
            ItemRepositoryInterface::class,
            ItemRepository::class
        );

        $this->app->bind(
            BattleRepositoryInterface::class,
            BattleRepository::class
        );

        $this->app->bind(
            MessageRepositoryInterface::class,
            MessageRepository::class
        );

        $this->app->bind(
            ImageRepositoryInterface::class,
            ImageRepository::class
        );


        return $this;
    }
}
