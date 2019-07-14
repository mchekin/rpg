<?php

namespace App\Providers;

use App\Http\ViewComposers\BattlesComposer;
use App\Http\ViewComposers\CharacterMessagesComposer;
use App\Http\ViewComposers\MessagesComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('message.index', MessagesComposer::class);

        View::composer('character.message.index', CharacterMessagesComposer::class);

        View::composer('character.battle.index', BattlesComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}