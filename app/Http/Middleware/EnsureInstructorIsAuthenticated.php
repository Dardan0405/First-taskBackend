<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureInstructorIsAuthenticated
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
        // Ensure the user is authenticated and has the 'instructor' role
        if (Auth::check() && Auth::user()->role === 'instructor') {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized access'], 403);
    }
}
