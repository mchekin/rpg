<?php

namespace App\Http\Middleware;

use App\Character;
use App\Location;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanMoveToLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Character $character */
        $character = Character::query()->findOrFail($request->route('character'));

        /** @var Location $location */
        $location = Location::query()->findOrFail($request->route('location'));

        /** @var Location $characterLocation */
        $characterLocation = $character->location;

        // if this character does not belong to the logged in user
        if (Auth::user()->id !== $character->user->id || !$characterLocation->isAdjacentLocation($location)) {
            return redirect()->route('location.show', $location->getId());
        }

        return $next($request);
    }
}
