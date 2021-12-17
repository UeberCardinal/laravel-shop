<?php

namespace App\Http\Controllers;

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
        $orderId = session('orderId');
        if (!is_null($orderId)) {
            $order = Order::findOrFail($orderId);
            return view('basket.basket', compact('order'));
        }
        //$sumPrice = array_sum($order->products()->pluck('price')->toArray());
        /*if (is_null($orderId)){
            return redirect()->route('home.index')->with('error', 'Ваша корзина пуста');
        }*/
        return view('basket.basket');
    }

    public function basketPlace()
    {
        $orderId = session('orderId');
        if (!is_null($orderId)) {
            $order = Order::findOrFail($orderId);
            if (!$order->products->count()){
                return redirect()->route('basket')->with('error', 'Ваша корзина пуста');
            }
            return view('basket.order', compact('order'));
        }
        return redirect()->route('basket');
    }

    public function addToBasket($productId)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            $order = Order::create();
            session(['orderId' => $order->id]);
        } else {
            $order = Order::find($orderId);
            //dd($order);
        }
        if ($order->products->contains($productId)) {
           $pivotRow = $order->products()->where('product_id', $productId)->first()->pivot;
           $pivotRow->count++;
           $pivotRow->update();
        } else {
            $order->products()->attach($productId);
        }

        if (Auth::check()) {
            $order->user_id = Auth::id();
            $order->save();
        }
        $product = Product::find($productId);
        return redirect()->route('basket')->with('success', "Товар {$product->name} добавлен в корзину");
    }

    public function removeFromBasket($productId)
    {
        $orderId = session('orderId');
        $order = Order::find($orderId);
        if (is_null($orderId)) {
            return redirect()->route('basket');
        }
        if ($order->products()->where('product_id', $productId)->first()->pivot->count == 1){
            $order->products()->detach($productId);
            return redirect()->route('basket');
        }
        $productPivot = $order->products()->where('product_id', $productId)->first()->pivot;
        $productPivot->count--;
        $productPivot->update();
        $product = Product::find($productId);
        return redirect()->route('basket')->with('warning', "Товар {$product->name} удален из корзины");
    }

    public function basketConfirm(Request $request)
    {
        $orderId = session('orderId');
        if (is_null($orderId)){
            return redirect()->route('home');
        }
        $order = Order::find($orderId);
        $order->update($request->all());
        session()->forget('orderId');
        return redirect()->route('home')->with('success', 'Товар принят в обработку');
    }
}
