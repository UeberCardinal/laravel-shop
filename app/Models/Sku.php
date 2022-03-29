<?php

namespace App\Models;

use App\Services\CurrencyConversion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sku extends Model
{

    use HasFactory, SoftDeletes;
    protected $visible = ['id', 'count', 'price', 'product_name'];
    protected $fillable = ['product_id', 'count', 'price'];
   // protected $guarded = ['created_at', 'updated_at', 'deleted_at', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('count', '>', 0);
    }

    public function propertyOption()
    {
        return $this->belongsToMany(PropertyOption::class, 'sku_property_option')->withTimestamps();
    }

    public function isAvailable()
    {
        return !$this->product->trashed() && $this->count > 0;
    }

    public function getPriceForCount()
    {
        if (!is_null($this->pivot)) {
            return $this->pivot->count * $this->price;
        }
        return $this->price;
    }

    public function sumProduct()
    {
        return $this->pivot->count * $this->pivot->price;
    }

    public function getPriceAttribute($value)
    {
        return round(CurrencyConversion::convert($value), 2);
    }

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }


}

