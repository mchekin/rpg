<?php

namespace App\Http\Middleware;

use App\Models\Character;
use App\Models\User;
use Closure;

class UserOwnsCharacter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        /** @var Character $character */
        $character = Character::query()->findOrFail($request->route('character'));

        if ($user && !$user->hasThisCharacter($character)) {
            return redirect()->back();
        }

        return $next($request);
    }
}
