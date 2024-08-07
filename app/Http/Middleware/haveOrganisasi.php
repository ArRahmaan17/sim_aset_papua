<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class haveOrganisasi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('organisasi') == null && ! $request->routeIs('home') && session('app') == 'aset') {
            return redirect()->route('home')->with('error', 'Anda belum menatapkan organisasi, silahkan tetapkan organisasi terlebih dahulu untuk mengakses '.implode(' ', explode('.', $request->route()->getName())));
        } else {
            return $next($request);
        }
    }
}
