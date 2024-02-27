<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Request $request): void
    {
        // if (session('user')->idrole != 1) {
        // $menu = DB::table('menu as m')
        //     ->selectRaw('m.*, rm.idrole')
        //     ->join('role_menu as rm', 'm.idmenu', '=', 'rm.idmenu')
        //     ->where('rm.idrole', session('user')->idrole)
        //     ->get();
        // } else {
        $menu = DB::table('menu as m')
            ->select('idmenu as id', 'parents as parent', 'icons', 'nama', 'link')
            ->get()->toArray();
        $menu = buildTree($menu);
        // }
        View::composer('*', function ($view) use ($menu) {
            $view->with(['menu' => $menu]);
        });
    }
}
