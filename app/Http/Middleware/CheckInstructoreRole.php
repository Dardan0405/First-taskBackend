<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckInstructoreRole
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'instructor') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Access Denied');
    }
}
