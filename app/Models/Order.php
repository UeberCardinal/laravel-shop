<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'status', 'user_id','currency_id', 'sum'];

    public function skus()
    {
        return $this->belongsToMany(Sku::class)->withPivot('count', 'price')->withTimestamps();
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function calculateFullSum()
    {
        $sum = 0;
        foreach ($this->skus()->withTrashed()->get() as $sku){
            $sum += $sku->sumProduct();

        }
        return $sum;
    }

    public function getFullSum()
    {
        $sum = 0;
        foreach ($this->skus as $sku) {
            $sum += $sku->price * ($sku->countInOrder ?? 1);
        }
        return $sum;
    //    return session('full_order_sum', 0);
    }

    public function user()
    {
        return $this->belongsTo(Order::class);
    }

    public function saveMyOrder($name, $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->status = 1;
        $this->sum = $this->getFullSum();
        $skus = $this->skus;
        $this->save();
        foreach ($skus as $skuInOrder){
            $this->skus()->attach($skuInOrder, [
                'count' =>  $skuInOrder->countInOrder,
                'price' => $skuInOrder->price
            ]);
        }

        session()->forget('order');
        return true;

    }


}
