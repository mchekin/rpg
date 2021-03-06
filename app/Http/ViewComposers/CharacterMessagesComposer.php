<?php

namespace App\Http\ViewComposers;

use App\Models\Character;
use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CharacterMessagesComposer
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
        $otherCharacter = Arr::get($data, 'character');

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

        $contentLimit = Message::CONTENT_LIMIT;

        $view->with(compact('messages', 'currentCharacter', 'otherCharacter', 'contentLimit'));
    }
}
