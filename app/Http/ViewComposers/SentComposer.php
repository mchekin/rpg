<?php

namespace App\Http\ViewComposers;

use App\User;
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
        /** @var User $currentUser */
        $currentUser = Auth::user();

        $sentMessages = $currentUser->sent()->orderByDesc('created_at')->paginate(5);

        $view->with('sentMessages', $sentMessages);
    }
}