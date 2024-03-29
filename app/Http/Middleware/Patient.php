<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Patient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth()->check()) {
            if (Auth()->user()->role == "Patient") {
                return $next($request);
            }
            return back();
        } else {
            return back();
        }
    }
}
