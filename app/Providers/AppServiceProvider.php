<?php

namespace App\Providers;

use App\Character;
use App\Contracts\CharacterInterface;
use App\Contracts\CharacterRepositoryInterface;
use App\Repositories\EloquentCharacterRepository;
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
        $this->app->bind(
            CharacterInterface::class,
            Character::class
        );

        $this->app->bind(
            CharacterRepositoryInterface::class,
            EloquentCharacterRepository::class
        );
    }
}
