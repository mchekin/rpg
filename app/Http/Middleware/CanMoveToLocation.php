<?php

namespace App\Http\Middleware;

use App\Character;
use App\Contracts\Models\LocationInterface;
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
        $character = $request->route('character');

        /** @var LocationInterface $location */
        $location = $request->route('location');

        /** @var LocationInterface $characterLocation */
        $characterLocation = $character->location;

        // if this character does not belong to the logged in user
        if (Auth::user()->id !== $character->user->id || !$characterLocation->isAdjacentLocation($location)) {
            return redirect()->route('location.show', compact('location'));
        }

        return $next($request);
    }
}
