<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTodayIsWeekend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $dayOfWeek = now()->dayOfWeek;
        if ($dayOfWeek === 1 || $dayOfWeek === 0) {
            return $next($request);
        }

        abort(403, "The website can only be accessed on weekends");
    }
}
