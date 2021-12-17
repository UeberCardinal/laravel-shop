<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'name', 'slug', 'description', 'image'
    ];


   public function products()
   {
       return $this->hasMany(Product::class);
   }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getImage()
    {
        return asset('/storage/' . $this->image);
    }


}
