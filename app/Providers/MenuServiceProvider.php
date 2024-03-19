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
        $menu_sidebar = DB::table('menu as m')
            ->select('idmenu as id', 'parents as parent', 'icons', 'nama', 'link')
            ->where('letak', 'sidebar')
            ->get()->toArray();
        $menu_sidebar = buildTree($menu_sidebar);
        $menu_profile = DB::table('menu as m')
            ->select('idmenu as id', 'parents as parent', 'icons', 'nama', 'link')
            ->where('letak', 'profile')
            ->get()->toArray();
        $menu_profile = buildTree($menu_profile);
        View::composer('*', function ($view) use ($menu_sidebar, $menu_profile) {
            $view->with([
                'menu_sidebar' => $menu_sidebar,
                'menu_profile' => $menu_profile
            ]);
        });
    }
}
