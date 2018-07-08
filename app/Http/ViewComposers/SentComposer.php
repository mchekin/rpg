<?php

namespace App\Http\ViewComposers;

use App\Character;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SentComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        /** @var Character $currentCharacter */
        $currentCharacter = Auth::user()->character;

        $sentMessages = $currentCharacter->sentMessages()->orderByDesc('created_at')->paginate(5);

        $view->with('sentMessages', $sentMessages);
    }
}