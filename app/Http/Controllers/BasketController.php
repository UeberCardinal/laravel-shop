<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BasketController extends Controller
{
    public function basket()
    {
     //   \session()->flush();
        $order = (new Basket())->getOrder();
        //$sumPrice = array_sum($order->products()->pluck('price')->toArray());
        /*if (is_null($orderId)){
            return redirect()->route('home.index')->with('error', 'Ваша корзина пуста');
        }*/
        return view('basket.basket', compact('order'));
    }

    public function basketPlace()
    {
        $basket = new Basket();
        $order = $basket->getOrder();
        if (!$basket->countAvailable()) {
            session()->flash('warning', "Товар недоступен");
            return redirect()->route('basket');
        }

        return view('basket.order', compact('order'));
    }

    public function addToBasket(Sku $sku)
    {
        $result = (new Basket(true))->addSku($sku);
        if ($result) {
            session()->flash('success', "Товар {$sku->name} добавлен в корзину");
        } else {
            session()->flash('warning', "Товар {$sku->name} недоступен");
        }


        return redirect()->route('basket');
    }

    public function removeFromBasket(Sku $sku)
    {
        (new Basket())->removeSku($sku);
        session()->flash('warning', 'Удален товар  ' . $sku->name);
        return redirect()->route('basket');
    }

    public function basketConfirm(Request $request)
    {
        $email = Auth::check() ? Auth::user()->email : $request->email;

        if ((new Basket())->saveOrder($request->name, $request->phone, $email)) {
            session()->flash('success', 'Товар принят в обработку');
            session()->forget('full_order_sum');
            session()->forget('fullSumWithoutPromocode');
            session()->forget('promocode');
        } else {
            session()->flash('warning', "Товар недоступен");
        }

        return redirect()->route('home.index');
    }

    public function applyPromocode(Request $request)
    {
        $promocode = Promocode::where('name', $request->promocode)->first();
        session(['promocode' => $promocode]);
        return back()->with('success', 'Промокод применен');
    }

    public function removePromocode()
    {
        session()->forget('promocode');
        session()->forget('fullSumWithoutPromocode');
        return redirect()->route('basket')->with('success', 'Промокод удален');
    }
}
