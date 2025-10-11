<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class BlockLoginTime
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow root and logout routes
        return $next($request);
        if ($request->is('/') || $request->is('logout') || $request->is('login')) {
            return $next($request);
        }

        // Restrict login route
        
            $now = Carbon::now();

            // Block between 12:00 AM and 7:00 AM
            $blockStart = Carbon::createFromTime(1, 0);  // 12:00 AM
            $blockEnd   = Carbon::createFromTime(7, 0);  // 7:00 AM

            if ($now->between($blockStart, $blockEnd)) {
                return redirect('logout');
            }
        

        return $next($request);
    }
}
