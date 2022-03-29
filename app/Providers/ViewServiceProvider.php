<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['master', 'category/categories'], 'App\ViewComposers\CategoriesComposer');
        View::composer(['master', 'admin.coupon.create', 'admin.coupon.edit'], 'App\ViewComposers\CurrenciesComposer');
        View::composer(['master'], 'App\ViewComposers\BestProductsComposer');
    }
}
