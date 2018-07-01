<?php

namespace App\Http\ViewComposers;

use App\Message;
use App\User;
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
        /** @var User $currentUser */
        $currentUser = Auth::user();

        $receivedMessages = $currentUser->receivedMessages()->orderByDesc('created_at')->paginate(5);

        Message::query()->whereIn('id', $receivedMessages->pluck('id'))->markAsRead();

        $view->with('receivedMessages', $receivedMessages);
    }
}