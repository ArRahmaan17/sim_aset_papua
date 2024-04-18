<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! session('user') && ! session('app')) {
            return $next($request);
        } elseif (session('user') && ! session('app')) {
            return redirect()->route('select-application');
        } else {
            return redirect()->route('home');
        }
    }
}
