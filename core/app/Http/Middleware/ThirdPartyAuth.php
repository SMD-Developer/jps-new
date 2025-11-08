<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; // Make sure this is the correct import

class ThirdPartyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth('third_party')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('third.party.login')->with('error', 'Please login first.');
        }

        return $next($request);
    }
}