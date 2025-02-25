<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is an admin
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            return $next($request);
        }

        // Redirect non-admin users to the home page or show an error
        return redirect('/')->with('error', 'You do not have access to this page.');
    }
}
