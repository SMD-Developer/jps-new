<?php

namespace App\Http\Middleware;

use Closure;

class ThirdPartyAuth
{
    public function handle($request, Closure $next)
    {
        \Log::info('Middleware executing', [
            'url' => $request->url(),
            'session_id' => $request->session()->getId(),
            'user_id' => $request->session()->get('third_party_user_id'),
            'all_session' => $request->session()->all()
        ]);

        // Check if user is authenticated
        if (!$request->session()->has('third_party_user_id')) {
            \Log::warning('Middleware: No user ID, redirecting to login');
            return redirect()->route('third.party.login')
                ->with('error', 'Please login first.');
        }

        \Log::info('Middleware: User authenticated, proceeding');
        return $next($request);
    }
}