<?php

namespace App\Http\Middleware;

use App\Contracts\Models\UserInterface;
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
        /** @var UserInterface $user */
        $user = $request->user();
        $location = $user->character->location;

        if ($user && $user->hasCharacter() && $location->id !== $request->location->id) {
            return redirect()->route('location.show', compact('location'));
        }

        return $next($request);
    }
}
