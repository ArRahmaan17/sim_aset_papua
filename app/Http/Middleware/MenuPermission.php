<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class MenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = DB::table('auth.menu as m')
            ->join('auth.role_menu as rm', 'rm.idmenu', '=', 'm.idmenu')
            ->where(['m.link' => $request->route()->getName(), 'rm.idrole' => session('user')->idrole])->count() > 0 ? true : false;
        if ($data) {
            return $next($request);
        } else {
            return redirect()->route('home')->with('error', "Kamu Tidak Memiliki Akses ke " . implode(' ', explode('.', $request->route()->getName())));
        }
    }
}
