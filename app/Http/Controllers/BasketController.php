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
        $order = (new Basket())->getOrder();
        dd($order);
        //$sumPrice = array_sum($order->products()->pluck('price')->toArray());
        /*if (is_null($orderId)){
            return redirect()->route('home.index')->with('error', 'Ваша корзина пуста');
        }*/
        return view('basket.basket', compact('order'));
    }

    public function basketPlace()
    {
        $order = (new Basket())->getOrder();
        return view('basket.order', compact('order'));
    }

    public function addToBasket(Product $product)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            $order = Order::create();
            session(['orderId' => $order->id]);
        } else {
            $order = Order::findOrFail($orderId);
            //dd($order);
        }
        if ($order->products->contains($product->id)) {
           $pivotRow = $order->products()->where('product_id', $product->id)->first()->pivot;
        //   dd($pivotRow->count);
            if ($order->products()->where('product_id', $product->id)->first()->count == $pivotRow->count) {
                return back()->with('warning', 'Добавлено максимальное количество товара');
            }
            $pivotRow->count++;
           $pivotRow->update();
        } else {
            $order->products()->attach($product->id);
        }

        if (Auth::check()) {
            $order->user_id = Auth::id();
            $order->save();
        }
        Order::changeFullSum($product->price);
        return redirect()->route('basket')->with('success', "Товар {$product->name} добавлен в корзину");
    }

    public function removeFromBasket(Product $product)
    {
        $basket = new Basket();
        $orderId = session('orderId');
        $order = Order::findOrFail($orderId);
        if ($order->products->contains($product->id)) {
            $pivotRow = $order->products()->where('product_id', $product->id)->first()->pivot;
            if ($pivotRow->count < 2) {
                $order->products()->detach($product->id);
            } else {
                $pivotRow->count--;
                $pivotRow->update();
            }
        }
        Order::changeFullSum(-$product->price);
        session()->flash('warning', 'Удален товар  ' . $product->name);
        return redirect()->route('basket');
    }

    public function basketConfirm(Request $request)
    {
        $order = (new Basket())->getOrder();
        $order->update($request->all());
        session()->forget('orderId');
        session()->forget('full_order_sum');

        return redirect()->route('home.index')->with('success', 'Товар принят в обработку');
    }
}
