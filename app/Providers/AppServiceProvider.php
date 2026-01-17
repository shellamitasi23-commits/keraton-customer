<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share cart count ke semua view
        View::composer('* ', function ($view) {
            if (Auth::check()) {
                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            } else {
                $cartCount = 0;
            }

            $view->with('cartCount', $cartCount);
        });
    }

    public function register(): void
    {
        //
    }
}