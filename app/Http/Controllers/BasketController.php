<?php

namespace App\Http\Controllers;

use App\Classes\Basket;
use App\Http\Requests\AddCouponRequest;
use App\Models\Coupon;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Composer\Autoload\includeFile;

class BasketController extends Controller
{
    public function basket()
    {

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
        $basket = new Basket();
        if ($basket->getOrder()->hasCoupon() && !$basket->getOrder()->coupon->availableForUse()) {
            $basket->clearCoupon();
            session()->flash('warning', "Купон недоступен для использования");
            return redirect()->route('basket');
        }
        $email = Auth::check() ? Auth::user()->email : $request->email;
        if ((new Basket())->saveOrder($request->name, $request->phone, $email)) {
            session()->flash('success', 'Товар принят в обработку');
            session()->forget('full_order_sum');
        } else {
            session()->flash('warning', "Товар недоступен");
        }

        return redirect()->route('home.index');
    }

    public function setCoupon(AddCouponRequest $request)
    {

        $coupon = Coupon::where('code', $request->coupon)->first();

        if($coupon->availableForUse()) {

           (new Basket())->setCoupon($coupon);
            session()->flash('success', 'Купон был добавлен к заказу');
        } else {
            session()->flash('warning', 'Купон не может быть использован');
        }

        return redirect()->route('basket');
    }


}
