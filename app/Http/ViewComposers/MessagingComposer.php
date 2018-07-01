<?php

namespace App\Http\ViewComposers;

use App\Character;
use App\Message;
use App\User;
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

        /** @var User $currentUser */
        /** @var Character $otherCharacter */
        $currentUser = Auth::user();

        $otherCharacter = array_get($data, 'character');
        $otherUser = $otherCharacter->user;

        $messages = Message::query()->where(function (Builder $query) use ($currentUser, $otherUser) {
            $query->where([
                'to_id' => $currentUser->id,
                'from_id' => $otherUser->id,
            ]);
        })->orWhere(function (Builder $query) use ($currentUser, $otherUser) {
            $query->where([
                'to_id' => $otherUser->id,
                'from_id' => $currentUser->id,
            ]);
        })->orderByDesc('created_at')->paginate(5);

        $otherUser->sentMessages()->whereIn('id', $messages->pluck('id'))->markAsRead();

        $view->with(compact('messages', 'currentUser'));
    }
}