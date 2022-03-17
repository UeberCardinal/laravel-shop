<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyOption extends Model
{
    use HasFactory;
    protected $fillable = ['property_id', 'name', 'name_en'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function skus()
    {
        return $this->belongsToMany(Sku::class);
    }
}
