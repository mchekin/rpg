<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class IsCharacterLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();
        $locationId = $user->character->getLocationId();

        if ($user && $user->hasCharacter() && $locationId !== $request->route('location')) {
            return redirect()->route('location.show', $locationId);
        }

        return $next($request);
    }
}
