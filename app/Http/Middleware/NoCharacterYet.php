<?php

namespace App\Http\Middleware;

use App\User;
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
        /** @var User $user */
        $user = $request->user();

        if ($user && $user->hasCharacter()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
