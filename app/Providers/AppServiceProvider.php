<?php

namespace App\Providers;
use App\Models\Menu;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
             $menus = Menu::with(['submenus' => function ($q) {
            $q->where('status', 1)->orderBy('order_by');
        }])
        ->where('status', 1)
        ->orderBy('order_by')
        ->get();

        $view->with('menus', $menus);
    });
    }
}
