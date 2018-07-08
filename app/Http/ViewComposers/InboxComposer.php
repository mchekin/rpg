<?php

namespace App\Http\ViewComposers;

use App\Character;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InboxComposer
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

        $receivedMessages = $currentCharacter->receivedMessages()->orderByDesc('created_at')->paginate(5);

        Message::query()->whereIn('id', $receivedMessages->pluck('id'))->markAsRead();

        $view->with('receivedMessages', $receivedMessages);
    }
}