<?php

namespace App\Http\Middleware;

use Closure;

class HasCharacter
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
        if (!$request->user() || $request->user()->hasNoCharacter()) {
            return redirect()->route('character.create');
        }

        return $next($request);
    }
}
