<?php

namespace App\Http\ViewComposers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Inani\Messager\Message;

class MessagingComposer
{

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $data = $view->getData();

        /** @var \App\Character $currentUserCharacter */
        /** @var \App\Character $character */
        $currentUserCharacter = array_get($data, 'currentUserCharacter');
        $character = array_get($data, 'character');

        $messages = Message::query()->where(function (Builder $query) use ($currentUserCharacter, $character) {
            $query->where([
                'to_id' => $currentUserCharacter->user->id,
                'from_id' => $character->user->id,
            ]);
        })->orWhere(function (Builder $query) use ($currentUserCharacter, $character) {
            $query->where([
                'to_id' => $character->user->id,
                'from_id' => $currentUserCharacter->user->id,
            ]);
        })->orderByDesc('created_at')->paginate(5);


        $view->with('messages', $messages);
    }
}