<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'status'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }



    public function getFullPrice()
    {
        $sum = 0;
        foreach ($this->products as $product){
            $sum += $product->sumProduct();

        }
        return $sum;
    }

    public function user()
    {
        return $this->belongsTo(Order::class);
    }


}
