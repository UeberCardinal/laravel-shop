<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;
    use Sluggable;
    use Translatable;
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'name_en', 'description_en'
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
