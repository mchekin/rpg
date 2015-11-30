<?php

namespace App\Http\Middleware;

use Closure;

class NoCharacterYet
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
        $user = $request->user();

        if ($user && $user->hasCharacter()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
