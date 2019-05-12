<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class UpdateLastUserActivity
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
        if($user) {

            $user->updateLastUserActivity();
        }

        return $next($request);
    }
}
