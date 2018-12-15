<?php

namespace App\Http\Middleware;

use App\Contracts\Models\UserInterface;
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
        /** @var UserInterface $user */
        $user = $request->user();
        if($user) {

            $user->updateLastUserActivity();
        }

        return $next($request);
    }
}
