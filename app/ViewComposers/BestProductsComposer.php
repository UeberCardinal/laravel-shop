<?php


namespace App\ViewComposers;




use App\Models\Order;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\View\View;


class BestProductsComposer
{
    public function compose(View $view)
    {

        $bestSkusIds = Order::get()->map->skus->flatten()->map->pivot->mapToGroups(function ($pivot){
            return [$pivot->sku_id => $pivot->count];
        })->map->sum()->sortDesc()->slice(0,3)->keys();
        $bestSkus = Sku::whereIn('id', $bestSkusIds)->get();
        $view->with('bestSkus', $bestSkus);


    }

}
