<?php

namespace App\Providers;
use App\Models\Cart;
use App\Models\Kategori;
use Illuminate\Support\Facades\View;

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
    public function boot()
    {
        View::composer('*', function ($view) {
            $cartCount = 0;
            $navbarCategories = Kategori::latest()->get(['id', 'nama']);

            if (auth()->check()) {
                $cartCount = Cart::where('user_id', auth()->id())->sum('qty');
            }

            $view->with('cartCount', $cartCount);
            $view->with('navbarCategories', $navbarCategories);
        });
    }
}
