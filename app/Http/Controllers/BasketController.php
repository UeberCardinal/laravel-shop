<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Models\Order;
use App\Models\Product;
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

    public function addToBasket(Product $product)
    {
        $result = (new Basket(true))->addProduct($product);
        if ($result) {
            session()->flash('success', "Товар {$product->name} добавлен в корзину");
        } else {
            session()->flash('warning', "Товар {$product->name} недоступен");
        }


        return redirect()->route('basket');
    }

    public function removeFromBasket(Product $product)
    {
        (new Basket())->removeProduct($product);
        session()->flash('warning', 'Удален товар  ' . $product->name);
        return redirect()->route('basket');
    }

    public function basketConfirm(Request $request)
    {
        $email = Auth::check() ? Auth::user()->email : $request->email;

        if ((new Basket())->saveOrder($request->name, $request->phone, $email)) {
            session()->flash('success', 'Товар принят в обработку');
            session()->forget('full_order_sum');
        } else {
            session()->flash('warning', "Товар недоступен");
        }

        return redirect()->route('home.index');
    }
}
