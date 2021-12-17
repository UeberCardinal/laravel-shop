<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;

class BasketIsNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $orderId = session('orderId');
        if (!is_null($orderId)) {
            $orderProducts = Order::findOrFail($orderId);
            if ($orderProducts->products->count() > 0) {
                return $next($request);
            }
        }
        return redirect()->route('home.index')->with('warning', 'Ваша корзина пуста!');

    }
}
