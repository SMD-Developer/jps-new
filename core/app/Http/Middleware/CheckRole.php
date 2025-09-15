<?php namespace App\Http\Middleware;


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            return redirect()->route('unauthorized')->with('message', 'You do not have the required role.');
        }

        return $next($request);
    }
}