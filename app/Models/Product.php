<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use App\Services\CurrencyConversion;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Sluggable;
    use Translatable;
    protected $fillable = ['name', 'description', 'slug', 'price', 'category_id', 'image', 'hit', 'new', 'recommend',
        'count', 'name_en', 'description_en'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //TODO: check table name for relation
    public function skus()
    {
        return $this->hasMany(Sku::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_product')->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function sumProduct()
    {
        if (!is_null($this->pivot)) {
            return $this->pivot->count * $this->price;
        }
        return $this->price;
    }

    public function scopeHit($query)
    {
        return $query->where('hit', 1);
    }

    public function scopeNew($query)
    {
        return $query->where('new', 1);
    }

    public function scopeRecommend($query)
    {
        return $query->where('recommend', 1);
    }

    public function isAvailable()
    {
        return $this->count > 0 && !$this->trashed();
    }

    public function setHitAttribute($value)
    {
        $this->attributes['hit'] = $value === 'on' ? 1 : 0;
    }

    public function setNewAttribute($value)
    {
        $this->attributes['new'] = $value === 'on' ? 1 : 0;
    }

    public function setRecommendAttribute($value)
    {
        $this->attributes['recommend'] = $value === 'on' ? 1 : 0;
    }

    public function isHit()
    {
        return $this->hit === 1;
    }

    public function isNew()
    {
        return $this->new === 1;
    }

    public function isRecommend()
    {
        return $this->recommend === 1;
    }

    public function getPriceAttribute($value)
    {
        return round(CurrencyConversion::convert($value), 2);
    }

    public function getCurrencyAttribute()
    {
        session('currency', 'RUB');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
