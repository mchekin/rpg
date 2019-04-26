<?php

namespace App\Providers;

use App\Modules\Battle\Domain\Contracts\BattleRepositoryInterface;
use App\Modules\Battle\Infrastructure\Repositories\BattleRepository;
use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Domain\Contracts\LocationRepositoryInterface;
use App\Modules\Character\Domain\Contracts\RaceRepositoryInterface;
use App\Modules\Character\Infrastructure\Repositories\CharacterRepository;
use App\Modules\Level\Domain\Contracts\LevelRepositoryInterface;
use App\Modules\Level\Infrastructure\Repositories\LevelRepository;
use App\Modules\Character\Infrastructure\Repositories\LocationRepository;
use App\Modules\Character\Infrastructure\Repositories\RaceRepository;
use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use App\Modules\User\Infrastructure\Repositories\UserRepository;
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
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            LevelRepositoryInterface::class,
            LevelRepository::class
        );

        $this->app->bind(
            RaceRepositoryInterface::class,
            RaceRepository::class
        );

        $this->app->bind(
            LocationRepositoryInterface::class,
            LocationRepository::class
        );

        $this->app->bind(
            CharacterRepositoryInterface::class,
            CharacterRepository::class
        );

        $this->app->bind(
            BattleRepositoryInterface::class,
            BattleRepository::class
        );


        return $this;
    }
}
