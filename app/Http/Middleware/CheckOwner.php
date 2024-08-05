<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOwner
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->owner) {
            return redirect()->route('user.profile', Auth::id())->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
