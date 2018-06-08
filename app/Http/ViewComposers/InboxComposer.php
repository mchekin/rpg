<?php

namespace App\Http\ViewComposers;

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

        $receivedMessages = $currentUser->received()->orderByDesc('created_at')->paginate(5);

        $view->with('receivedMessages', $receivedMessages);
    }
}