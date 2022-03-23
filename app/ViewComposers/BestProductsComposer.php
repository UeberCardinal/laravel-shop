<?php


namespace App\ViewComposers;




use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;


class BestProductsComposer
{
    public function compose(View $view)
    {

        $mostPopularProducts = Order::get()->map->skus->flatten()->map->pivot->mapToGroups(function ($pivot){
            return [$pivot->product_id => $pivot->count];
        })->map->sum()->sortDesc()->slice(0,3)->keys();
        $bestProducts = Product::whereIn('id', $mostPopularProducts)->get();

        $view->with('bestProducts', $bestProducts);


    }

}
