<?php

namespace App\Http\ViewComposers;

use App\Character;
use App\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MessagingComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $data = $view->getData();

        /** @var Character $currentCharacter */
        /** @var Character $otherCharacter */
        $currentCharacter = Auth::user()->character;
        $otherCharacter = array_get($data, 'character');

        $messages = Message::query()->where(function (Builder $query) use ($currentCharacter, $otherCharacter) {
            $query->where([
                'to_id' => $currentCharacter->id,
                'from_id' => $otherCharacter->id,
            ]);
        })->orWhere(function (Builder $query) use ($currentCharacter, $otherCharacter) {
            $query->where([
                'to_id' => $otherCharacter->id,
                'from_id' => $currentCharacter->id,
            ]);
        })->orderByDesc('created_at')->paginate(5);

        $otherCharacter->sentMessages()->whereIn('id', $messages->pluck('id'))->markAsRead();

        $view->with(compact('messages', 'currentCharacter'));
    }
}