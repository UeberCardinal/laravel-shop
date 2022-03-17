<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->active()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        if (!Auth::user()->orders->contains($id)) {
            return back();
        }
        $order = Order::find($id);


        return view('admin.orders.show', compact('order'));
    }
}
