<?php

namespace App\Http\Middleware;

use Closure;

class MoverFinishedRegistration
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
        $mover = $request->user();

        if (!$mover->cars()->first() && $mover->isMover()) {
            return redirect(url('/account/register/step/2'));
        }

        return $next($request);
    }
}
