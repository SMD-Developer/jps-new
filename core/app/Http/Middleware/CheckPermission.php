<?php namespace App\Http\Middleware;


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!$request->user() || !$request->user()->hasPermission($permission)) {
            return redirect()->route('unauthorized')->with('message', 'You do not have the required permission.');
        }

        return $next($request);
    }
}