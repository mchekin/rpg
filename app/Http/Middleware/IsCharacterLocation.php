<?php

namespace App\Http\Middleware;

use App\User;
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
        $location = $user->character->location;

        if ($user && $user->hasCharacter() && $location->id !== $request->location->id) {
            return redirect()->route('location.show', compact('location'));
        }

        return $next($request);
    }
}
