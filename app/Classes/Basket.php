<?php


namespace App\Classes;


use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use App\Services\CurrencyConversion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Basket
{
    protected $order;

    /**
     * Basket constructor.
     */
    public function __construct($createOrder = false)
    {
        $order = session('order');

        if (is_null($order) && $createOrder) {
            $data = [];
            if (Auth::check()) {
                $data['user_id'] = Auth::id();
            }
            $data['currency_id'] = CurrencyConversion::getCurrentCurrencyFromSession()->id;
            $this->order = new Order($data);
            session(['order' => $this->order]);
        } else {
            $this->order = $order;
        }


    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function countAvailable($updateCount = false)
    {

        $products = collect([]);
        foreach ($this->order->products as $orderProduct)
        {
            $product = Product::find($orderProduct->id);
            if ($orderProduct->countInOrder > $product->count) {
                return false;
            }
            if ($updateCount) {
                $product->count -= $orderProduct->countInOrder;
                $products->push($product);
            }
        }
      //  dd($products);
        if ($updateCount) {
            $products->map->save();
        }
        return true;
    }
    public function saveOrder($name, $phone, $email)
    {
        if (!$this->countAvailable(true)) {
            return false;

        }
        $this->order->saveMyOrder($name, $phone);
        Mail::to($email)->send(new OrderCreated($name, $this));
        return true;
    }

   /* protected function getPivotRow($product)
    {
        return $this->order->products()->where('product_id', $product->id)->first()->pivot;
    }*/

    public function removeProduct(Product $product)
    {
        if ($this->order->products->contains($product)) {
            $pivotRow = $this->order->products->where('id', $product->id)->first();
          //  dd($pivotRow->countInOrder);
            if ($pivotRow->countInOrder < 2) {
                foreach (session('order')->products as $key => $value){
                    if($product->id == $value->id) {
                     //   dd($key, $value->id, $product->id);
                        $this->order->products->forget($key);
                    }
                }
            } else {
                $pivotRow->countInOrder--;
            }
        }
    }

    public function addProduct(Product $product)
    {
        if ($this->order->products->contains($product->id)) {
            $pivotRow = $this->order->products->where('id', $product->id)->first();
            //dd($pivotRow, $product);
            if ($pivotRow->countInOrder >= $product->count) {
                return false;
            }
            $pivotRow->countInOrder++;
        } else {
            if ($product->count == 0) {
                return false;
            }
            $product->countInOrder = 1;
            $this->order->products->push($product);
        }

        return true;
    }


}
