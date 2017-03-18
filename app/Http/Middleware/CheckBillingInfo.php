<?php

namespace App\Http\Middleware;

use Closure;

class CheckBillingInfo
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
        if (!$request->user()->billingInfo()->first()) {
            session()->set('bidding_redirect', $request->path());
            return redirect(url('/account/billing-info/first'));
        }

        if ($request->user()->getBalance() < 0) {
            session()->set('bidding_redirect', $request->path());
            return redirect(url('/account/billing-info'));
        }

        return $next($request);
    }
}
