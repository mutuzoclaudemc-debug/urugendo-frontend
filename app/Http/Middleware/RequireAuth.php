<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RequireAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('api_token')) {
            return redirect('/login')->with('error', 'Please log in to continue.');
        }

        return $next($request);
    }
}
