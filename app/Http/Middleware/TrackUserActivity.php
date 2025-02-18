<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class TrackUserActivity 
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Auth::user()->update(['last_seen_at' => now()]);
        }

        return $next($request);
    }
}
