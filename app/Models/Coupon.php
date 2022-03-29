<?php

namespace App\Models;

use App\Services\CurrencyConversion;
use Carbon\Carbon;
use Faker\Provider\en_US\Text;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'value', 'type', 'currency_id', 'only_once', 'expired_at', 'description'];
    protected $dates = ['expired_at'];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public static function couponGenerator()
    {
        $couponCode = Str::random(random_int(4,6)) . rand(0,99);
        return $couponCode;
    }
    public function isAbsolute()
    {
        return $this->type;
    }

    public function isOnlyOnce()
    {
        return $this->only_once;
    }

    public function availableForUse()
    {
        $this->refresh();
        if (!$this->isOnlyOnce() || $this->orders->count() === 0){
            return is_null($this->expired_at) || $this->expired_at->gte(Carbon::now());
        }
    }

    public function applyCost($price, Currency $currency = null)
    {
        if ($this->isAbsolute()) {
            return $price - CurrencyConversion::convert($this->value, $this->currency->code, $currency->code);
        } else {
            return $price - ($price * $this->value / 100);
        }
    }

}
