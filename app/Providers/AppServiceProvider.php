<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

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
        Schema::defaultStringLength(191);

        $setting = Setting::first();
        View::share('setting', $setting);

        View::composer('*', function ($view) {
            $cart = session()->get('cart', []);

            // Total Quantity Count
            $cartCount = array_sum(array_column($cart, 'qty'));

            $view->with('cartCount', $cartCount);
        });
    }
}
