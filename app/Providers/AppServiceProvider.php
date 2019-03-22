<?php

namespace App\Providers;

use App\Battle;
use App\BattleRound;
use App\BattleTurn;
use App\Character;
use App\Contracts\Models\BattleInterface;
use App\Contracts\Models\BattleRoundInterface;
use App\Contracts\Models\BattleTurnInterface;
use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\LevelInterface;
use App\Contracts\Models\LocationInterface;
use App\Contracts\Models\MessageInterface;
use App\Contracts\Models\RaceInterface;
use App\Contracts\Models\UserInterface;
use App\Contracts\Repositories\BattleRepositoryInterface;
use App\Contracts\Repositories\CharacterRepositoryInterface;
use App\Contracts\Repositories\RaceRepositoryInterface;
use App\Modules\User\Domain\Contracts\UserRepositoryInterface;
use App\Level;
use App\Location;
use App\Message;
use App\Race;
use App\Repositories\BattleRepository;
use App\Repositories\CharacterRepository;
use App\Repositories\RaceRepository;
use App\Modules\User\Infrastructure\Repositories\UserRepository;
use App\User;
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
        $this->registerModelInterfaces()
            ->registerRepositoryInterfaces();
    }

    protected function registerModelInterfaces(): self
    {
        $this->app->bind(
            BattleInterface::class,
            Battle::class
        );

        $this->app->bind(
            BattleRoundInterface::class,
            BattleRound::class
        );

        $this->app->bind(
            BattleTurnInterface::class,
            BattleTurn::class
        );

        $this->app->bind(
            CharacterInterface::class,
            Character::class
        );

        $this->app->bind(
            LevelInterface::class,
            Level::class
        );

        $this->app->bind(
            LocationInterface::class,
            Location::class
        );

        $this->app->bind(
            MessageInterface::class,
            Message::class
        );

        $this->app->bind(
            RaceInterface::class,
            Race::class
        );

        $this->app->bind(
            UserInterface::class,
            User::class
        );

        return $this;
    }

    protected function registerRepositoryInterfaces(): self
    {
        $this->app->bind(
            BattleRepositoryInterface::class,
            BattleRepository::class
        );

        $this->app->bind(
            CharacterRepositoryInterface::class,
            CharacterRepository::class
        );

        $this->app->bind(
            RaceRepositoryInterface::class,
            RaceRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        return $this;
    }
}
