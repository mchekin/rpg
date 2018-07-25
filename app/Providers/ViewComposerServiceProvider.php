<?php

namespace App\Providers;

use App\Http\ViewComposers\InboxComposer;
use App\Http\ViewComposers\MessagingComposer;
use App\Http\ViewComposers\SentComposer;
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
        View::composer('message.index', MessagingComposer::class);
        View::composer('message.inbox', InboxComposer::class);
        View::composer('message.sent', SentComposer::class);
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