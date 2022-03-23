<?php


namespace App\Classes;


use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sku;
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

        $skus = collect([]);
        foreach ($this->order->skus as $orderSku)
        {
            $sku = Sku::find($orderSku->id);
            if ($orderSku->countInOrder > $sku->count) {
                return false;
            }
            if ($updateCount) {
                $sku->count -= $orderSku->countInOrder;
                $skus->push($sku);
            }
        }
      //  dd($products);
        if ($updateCount) {
            $skus->map->save();
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

    public function removeSku(Sku $sku)
    {
        if ($this->order->skus->contains($sku)) {
            $pivotRow = $this->order->skus->where('id', $sku->id)->first();
          //  dd($pivotRow->countInOrder);
            if ($pivotRow->countInOrder < 2) {
                foreach (session('order')->skus as $key => $value){
                    if($sku->id == $value->id) {
                     //   dd($key, $value->id, $product->id);
                        $this->order->skus->forget($key);
                    }
                }
            } else {
                $pivotRow->countInOrder--;
            }
        }
    }

    public function addSku(Sku $sku)
    {
        if ($this->order->skus->contains($sku->id)) {
            $pivotRow = $this->order->skus->where('id', $sku->id)->first();
            //dd($pivotRow, $product);
            if ($pivotRow->countInOrder >= $sku->count) {
                return false;
            }
            $pivotRow->countInOrder++;
        } else {
            if ($sku->count == 0) {
                return false;
            }
            $sku->countInOrder = 1;
            $this->order->skus->push($sku);
        }

        return true;
    }


}
